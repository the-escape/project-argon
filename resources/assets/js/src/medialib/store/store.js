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
            // if (folder.name.startsWith('New Folder'))
            // {
            //     state.active.active = false
            //     state.back = state.active
            //     folder.items = []
            //     folder.setChildrenItems([])
            //     folder.active = true
            //     state.active = folder
            //     state.search.reset()
            //
            //     console.log("F:");
            //     console.log(folder);
            //     return
            // }

            getFolders(folder.id, function(f) {
                state.active.active = false
                state.back = state.active
                folder.items = f.items
                folder.setChildrenItems(f.children)
                folder.active = true
                state.active = folder
                state.search.reset()
            })
        },
        // loadLibrary: (state) => {
        //     getFolders('', function(folder) {
        //         folder = folder[0]
        //         state.folder = new Folder(folder.id, folder.name, folder.items, folder.children, null)
        //         state.active = state.folder
        //
        //         getFolders(state.folder.id, function(folder) {
        //             state.active.items = folder.items
        //             state.active.active = true
        //         })
        //     })
        // },
        folders: (state) => {
            getFoldersData(function(data) {
                state.data = data.reduce((a, v) => {
                    a[v.id] = v
                    return a
                }, {})

                let folders = children(state.data)
                state.folder = folders[0];
                state.active = state.folder

                getFolders(state.folder.id, function(f) {
                    state.active = new Folder(f.id, f.name, f.items, f.children, f.parent, true)
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
        createFolder: (state, parent) => {
            addFolder('New Folder', parent.id, function (r) {
                if (r.status !== 200) {
                    return alert(r.body.error)
                }

                let child = new Folder(r.body.id, r.body.name, [], [], parent)
                state.active.children.push(child)
            })
        },
        removeFolder: (state, folder) => {
            removeFolder(folder.id, function (r) {
                if (r.status !== 200) {
                    return alert(r.body.error)
                }

                // TODO: finish here
                state.active = folder.parent
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
        createFolder({ commit }, parent) {
            commit('createFolder', parent)
        }
    }
})

