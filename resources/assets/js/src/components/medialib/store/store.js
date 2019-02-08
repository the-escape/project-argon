import Vue from 'vue'
import Vuex from 'vuex'
import Noty from 'noty'
import {
    getFolders,
    getFoldersData,
    search,
    addFolder,
    editFolder,
    removeFolder,
    uploadMedia,
    removeItem,
    move
} from '../api/media'
import { Folder, children, Item } from './folder'
import { Search } from './search'
import { Upload } from './upload'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        isPicker: false,
        folder: new Folder(),
        folderMap: {},
        active: new Folder(),
        back: new Folder(),
        data: [],
        search: new Search(),
        editItem: new Item(),
        layout: 'tiles',
        upload: new Upload()
    },
    mutations: {
        loadFolders: (state, { folder, pushState }) => {
            if (pushState) {
                history.pushState(
                    { folderID: folder.id },
                    folder.name,
                    `?folder=${folder.name}&folderID=${folder.id}`
                )
            }

            getFolders(folder.id, function (f) {
                state.folder.active = false
                state.active.active = false
                state.back = state.active
                folder.setItems(f.items)
                folder.setChildren(f.children)
                folder.active = true
                state.active = folder
                state.search.reset()

                state.folderMap = {
                    ...state.folderMap,
                    ...folder.children.reduce((acc, folder) => {
                        acc[folder.id] = folder
                        return acc
                    }, {})
                }
            })
        },
        loadFoldersByID: (state, id) => {
            const folder = state.folderMap[id]

            if (!folder) {
                return
            }

            getFolders(folder.id, function (f) {
                state.folder.active = false
                state.active.active = false
                state.back = state.active
                folder.setItems(f.items)
                folder.setChildren(f.children)
                folder.active = true
                state.active = folder
                state.search.reset()

                state.folderMap = {
                    ...state.folderMap,
                    ...folder.children.reduce((acc, folder) => {
                        acc[folder.id] = folder
                        return acc
                    }, {})
                }
            })
        },
        folders: state => {
            getFoldersData(function (data) {
                state.data = data

                let { newFolders, folderMap } = children(state.data)
                state.folderMap = folderMap

                state.folder = new Folder(
                    newFolders[0].id,
                    newFolders[0].name,
                    newFolders[0].items,
                    newFolders[0].children,
                    newFolders[0].parent,
                    true
                )
                state.active = state.folder

                history.pushState(
                    { folderID: state.folder.id },
                    state.folder.name,
                    `?folder=${state.folder.name}&folderID=${state.folder.id}`
                )

                getFolders(state.folder.id, function (f) {
                    state.active.setItems(f.items)
                    state.active.setChildren(f.children)
                })
            })
        },
        search: (state, keywords) => {
            state.search.loading = true
            if (keywords === '') {
                state.search = new Search()
                return
            }
            search(keywords, function (data) {
                state.search = new Search(keywords, data)
            })
        },
        editItem: (state, item) => {
            if (!item) {
                state.editItem = new Item()
            } else {
                state.editItem = item
            }
        },
        setLayout: (state, layout) => {
            state.layout = layout
        },
        createFolder: (state, payload) => {
            addFolder(payload.name, payload.parent.id, function (r) {
                if (r.status !== 200) {
                    new Noty({
                        text: r.body.error,
                        type: 'error',
                        timeout: 3500
                    }).show()
                    return
                }

                let child = new Folder(
                    r.body.id,
                    r.body.name,
                    [],
                    [],
                    payload.parent
                )
                state.active.children.push(child)
            })
        },
        editFolder: (state, payload) => {
            editFolder(payload.name, payload.folder.id, function (r) {
                if (r.status !== 200) {
                    new Noty({
                        text: r.body.error,
                        type: 'error',
                        timeout: 3500
                    }).show()
                    return
                }

                // TODO: finish here
                console.log(r)
                state.active.name = r.body.name
            })
        },
        removeFolder: (state, folder) => {
            removeFolder(folder.id, function (r) {
                if (r.status !== 204) {
                    new Noty({
                        text: r.body.error,
                        type: 'error',
                        timeout: 3500
                    }).show()
                    return
                }

                let parent = folder.parent
                parent.active = true
                parent.children = parent.children.filter(
                    child => child.id !== folder.id
                )
                state.back = new Folder()
                state.active = parent

                new Noty({
                    text: `${folder.name} was removed`,
                    type: 'success',
                    timeout: 3500
                }).show()
            })
        },
        uploadItems: (state, payload) => {
            uploadMedia(payload, function (r) {
                console.log(r)

                if (r.status >= 400) {
                    new Noty({
                        text: r.body.error,
                        type: 'error',
                        timeout: 3500
                    }).show()
                    return
                }

                let msg = r.body.messages

                if (Array.isArray(msg)) {
                    msg = r.body.messages.join('\n')
                }

                getFolders(state.active.id, function (f) {
                    state.active.setItems(f.items)
                })

                state.upload.reset()

                if (msg) {
                    new Noty({
                        text: msg,
                        type: 'success',
                        timeout: 3500
                    }).show()
                }
            })
        },
        removeItem: (state, item) => {
            removeItem(item.item.id, function (r) {
                if (r.status >= 400) {
                    new Noty({
                        text: r.body.error,
                        type: 'error',
                        timeout: 3500
                    }).show()
                    return
                }

                item.hide = true
                new Noty({
                    text: `${item.getName()} was removed`,
                    type: 'success',
                    timeout: 3500
                }).show()
            })
        },
        move: (state, { destinationFolder, items, folders }) => {
            let data = {
                items: items.map(item => item.item.id),
                folders: folders.map(folder => folder.id),
                destinationFolder: destinationFolder.id
            }

            items.forEach(item => {
                item.hide = true
            })

            folders.forEach(folder => {
                folder.hide = true
            })

            move(data, function (r) {
                if (r.status >= 400) {
                    items.forEach(item => {
                        item.hide = false
                    })

                    folders.forEach(folder => {
                        folder.hide = false
                    })

                    new Noty({
                        text: r.body.error,
                        type: 'error',
                        timeout: 3500
                    }).show()
                    return
                }

                new Noty({
                    text: `${items.length + folders.length} items were moved`,
                    type: 'success',
                    timeout: 3500
                }).show()
            })
        }
    },
    actions: {
        folderSelected ({ commit }, { folder, pushState = true }) {
            commit('loadFolders', { folder, pushState })
        },
        loadLibrary ({ commit }) {
            commit('folders')
        },
        search ({ commit }, keywords) {
            commit('search', keywords)
        },
        editItem ({ commit }, item) {
            commit('editItem', item)
        },
        setLayout ({ commit }, layout) {
            commit('setLayout', layout)
        },
        createFolder ({ commit }, payload) {
            commit('createFolder', payload)
        },
        editFolder ({ commit }, payload) {
            commit('editFolder', payload)
        },
        removeFolder ({ commit }, active) {
            commit('removeFolder', active)
        },
        uploadItems ({ commit }, payload) {
            commit('uploadItems', payload)
        },
        removeItem ({ commit }, item) {
            commit('removeItem', item)
        },
        move ({ commit }, payload) {
            commit('move', payload)
        },
        folderSelectByID ({ commit }, id) {
            commit('loadFoldersByID', id)
        }
    }
})
