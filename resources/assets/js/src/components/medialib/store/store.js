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
    removeItem,
    move,
    recentUploads,
    remove,
    update
} from '../api/media'
import { Folder, children, Item } from './folder'
import { Search } from './search'
import { Upload } from './upload'

Vue.use(Vuex)

export default function () {
    return new Vuex.Store({
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
            upload: new Upload(),
            uploadIsOpen: false,
            recentUploads: {
                show: false,
                items: []
            },
            newUploadIds: []
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

                state.recentUploads.show = false

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
                loadFoldersByID(state, id)
            },
            loadLibrary: (state, id) => {
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
                        `?folder=${state.folder.name}&folderID=${
                            state.folder.id
                        }`
                    )

                    getFolders(state.folder.id, function (f) {
                        state.active.setItems(f.items)
                        state.active.setChildren(f.children)
                    })
                })

                recentUploads(response => {
                    state.recentUploads.items = response.body.data.map(
                        item => new Item(item)
                    )
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
            recentUploads: state => {
                state.recentUploads.show = true

                recentUploads(response => {
                    state.recentUploads.items = response.body.data.map(
                        item => new Item(item)
                    )
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
                            layout: 'topCenter',
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
                    state.active.addNewFolder(child)
                })
            },
            editFolder: (state, folder) => {
                editFolder(folder.name, folder.id, function (r) {
                    if (r.status !== 200) {
                        new Noty({
                            layout: 'topCenter',
                            text: r.body.error,
                            type: 'error',
                            timeout: 3500
                        }).show()

                        folder.name = folder.originalName
                    } else {
                        folder.parent.sortChildFolders()
                    }
                })
            },
            removeFolder: (state, folder) => {
                removeFolder(folder.id, function (r) {
                    if (r.status !== 204) {
                        new Noty({
                            layout: 'topCenter',
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
                        layout: 'topCenter',
                        text: `${folder.name} was removed`,
                        type: 'success',
                        timeout: 3500
                    }).show()
                })
            },
            uploadResult: (state, payload) => {
                if (!payload.successful.length) {
                    return
                }

                const newFileIds = payload.successful.reduce((acc, el) => {
                    const newFileIDs = el.response.body.fileIDs
                    acc = [...acc, ...newFileIDs]
                    return acc
                }, [])
                state.newUploadIds = newFileIds

                getFolders(state.active.id, function (f) {
                    state.active.setItems(f.items)
                })

                state.uploadIsOpen = false

                const maxLen = 3
                const isOverMax = payload.successful.length > maxLen
                const len = isOverMax ? maxLen : payload.successful.length
                const fileNames = []
                for (let i = 0; i < len; i++) {
                    fileNames.push(payload.successful[i].name)
                }
                let msg = fileNames.join(', ')
                if (isOverMax) {
                    msg += '...'
                }

                msg += ' uploaded'

                new Noty({
                    layout: 'topCenter',
                    text: msg,
                    type: 'success',
                    timeout: 3500
                }).show()
            },
            clearNewUploadIDs (state) {
                state.newUploadIds = []
            },
            removeItem: (state, item) => {
                removeItem(item.item.id, function (r) {
                    if (r.status >= 400) {
                        new Noty({
                            layout: 'topCenter',
                            text: r.body.error,
                            type: 'error',
                            timeout: 3500
                        }).show()
                        return
                    }

                    item.hide = true
                    new Noty({
                        layout: 'topCenter',
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
                            layout: 'topCenter',
                            text: r.body.error,
                            type: 'error',
                            timeout: 3500
                        }).show()
                        return
                    }

                    new Noty({
                        layout: 'topCenter',
                        text: `${items.length +
                            folders.length} items were moved`,
                        type: 'success',
                        timeout: 3500
                    }).show()
                })
            },
            toggleUploads: state => {
                state.uploadIsOpen = !state.uploadIsOpen
            },
            remove: (state, { items, folders }) => {
                let data = {
                    items: items.map(item => item.item.id),
                    folders: folders.map(folder => folder.id)
                }

                items.forEach(item => {
                    item.hide = true
                })
                folders.forEach(folder => {
                    folder.hide = true
                })

                remove(data, function (r) {
                    if (r.items.length || r.folders.length) {
                        const nonDeleteNames = []

                        if (r.items.length) {
                            items.forEach(item => {
                                if (~r.items.indexOf(item.item.id)) {
                                    item.hide = false
                                    nonDeleteNames.push(item.getName())
                                }
                            })
                        }
                        if (r.folders.length) {
                            folders.forEach(folder => {
                                if (~r.folders.indexOf(folder.id)) {
                                    folder.hide = false
                                    nonDeleteNames.push(folder.name)
                                }
                            })
                        }

                        new Noty({
                            layout: 'topCenter',
                            text:
                                nonDeleteNames.slice(0, 3).join(', ') +
                                ' Were unable to be deleted, folders must be empty before deleting',
                            type: 'error',
                            timeout: 3500
                        }).show()
                        return
                    }

                    let successMsg = `${items.length + folders.length} `
                    if (items.length && folders.length) {
                        successMsg += 'items/folders '
                    } else if (items.length) {
                        successMsg += 'item(s) '
                    } else if (folders.length) {
                        successMsg += 'folder(s) '
                    }
                    successMsg += 'were deleted'

                    new Noty({
                        layout: 'topCenter',
                        text: successMsg,
                        type: 'success',
                        timeout: 3500
                    }).show()
                })
            },
            updateMediaItem: (state, { item, file, name }) => {
                update({ id: item.item.id, file, name })
                    .then(data => {
                        new Noty({
                            layout: 'topCenter',
                            text: data.messages,
                            type: 'success',
                            timeout: 3500
                        }).show()
                        loadFoldersByID(state, item.item.folder)
                        item.updateCacheBuster()
                    })
                    .catch(e => {
                        new Noty({
                            layout: 'topCenter',
                            text: e.body.errors,
                            type: 'error',
                            timeout: 3500
                        }).show()
                    })
            }
        },
        actions: {
            folderSelected ({ commit }, { folder, pushState = true }) {
                commit('loadFolders', { folder, pushState })
            },
            loadLibrary ({ commit }, folderID) {
                commit('loadLibrary', folderID)
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
            removeItem ({ commit }, item) {
                commit('removeItem', item)
            },
            move ({ commit }, payload) {
                commit('move', payload)
            },
            folderSelectByID ({ commit }, id) {
                commit('loadFoldersByID', id)
            },
            toggleUploads ({ commit }) {
                commit('toggleUploads')
            },
            uploadResult ({ commit }, payload) {
                commit('uploadResult', payload)
            },
            recentUploads ({ commit }) {
                commit('recentUploads')
            },
            remove ({ commit }, payload) {
                commit('remove', payload)
            },
            clearNewUploadIDs ({ commit }) {
                commit('clearNewUploadIDs')
            },
            updateMediaItem ({ commit }, payload) {
                commit('updateMediaItem', payload)
            }
        }
    })
}

function loadFoldersByID (state, id) {
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
}
