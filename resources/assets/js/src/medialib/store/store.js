import Vue from 'vue'
import Vuex from 'vuex'
import { getFolders, getFoldersData, search, addFolder, removeFolder } from "../api/media";
import { Folder, children, Item } from "./folder"
import { Search } from "./search"

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        folder: new Folder,
        active: new Folder,
        back: new Folder,
        data: [],
        search: new Search,
        modal: new Item,
        layout: 'tiles'
    },
    // getters : {},
    mutations: {
        loadFolders: (state, folder) => {
            getFolders(folder.id, function(f) {
                state.folder.active = false
                state.active.active = false
                state.back = state.active
                folder.items = f.items
                folder.setChildrenItems(f.children)
                folder.active = true
                state.active = folder
                state.search.reset()
            })
        },
        folders: (state) => {
            getFoldersData(function(data) {
                state.data = data.reduce((a, v) => {
                    a[v.id] = v
                    return a
                }, {})

                let folders = children(state.data)

                state.folder = new Folder(folders[0].id, folders[0].name, folders[0].items, folders[0].children, folders[0].parent, true)
                state.active = state.folder

                getFolders(state.folder.id, function(f) {
                    state.active.items =  f.items
                })
            })
        },
        search: (state, keywords) => {
            state.search.loading = true
            if (keywords === '') {
                state.search = new Search
                return
            }
            search(keywords, function (data) {
                state.search = new Search(keywords, data)
            })
        },
        modal: (state, item) => {
            state.modal = new Item(item)
        },
        setLayout: (state, layout) => {
            state.layout = layout
        },
        createFolder: (state, payload) => {
            addFolder(payload.name, payload.parent.id, function (r) {
                if (r.status !== 200) {
                    return alert(r.body.error)
                }

                let child = new Folder(r.body.id, r.body.name, [], [], parent)
                state.active.children.push(child)
            })
        },
        editFolder: (state, folder) => {
            editFolder(folder, function (r) {
                if (r.status !== 200) {
                    return alert(r.body.error)
                }

                // TODO: finish here
                console.log(r);
            })
        },
        removeFolder: (state, folder) => {
            removeFolder(folder.id, function (r) {
                if (r.status !== 204) {
                    return alert(r.body.error)
                }

                alert("Folder removed.\nSwitching directory to parent folder...")

                let parent = folder.parent;
                parent.active = true
                parent.children =  parent.children.filter(child => child.id !== folder.id);
                state.back = new Folder()
                state.active = parent
            })
        }
    },
    actions: {
        loadFolders ({ commit }) {
            commit('loadFolders', 1)
        },
        folderSelected ({ commit }, folder) {
            commit('loadFolders', folder)
        },
        loadLibrary ({ commit }) {
            commit('folders')
            // commit('loadLibrary')
        },
        search({ commit }, keywords) {
            commit('search', keywords)
        },
        modal({ commit }, item) {
            commit('modal', item)
        },
        setLayout({ commit }, layout) {
            commit('setLayout', layout)
        },
        createFolder({ commit }, payload) {
            commit('createFolder', payload)
        },
        editFolder({ commit }, folder) {
            commit('editFolder', folder)
        },
        removeFolder({ commit }, active) {
            commit('removeFolder', active)
        }
    }
})

