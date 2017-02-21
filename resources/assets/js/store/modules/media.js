import { getFolders, getItems, searchItems, storeFolder } from '../../api/media'
import * as types from '../mutation-types'

const state = {

    loading: false,

    root: {},

    /**
     * The active folder.
     */
    folder: {},

    /**
     * An array of all folders.
     */
    folders: [],

    parents: [],

    /**
     * An array of items in the active folder.
     */
    items: [],

    /**
     * Current selected item.
     */
    item: {},

    creating: false
};

const getters = {

    rootFolder: state => state.root,

    /**
     * Returns the active folder.
     * @param state
     */
    activeFolder: state => state.folder,

    /**
     * Returns child folders of the active folder.
     * @param state
     * @returns {Array.<*>}
     */
    childFolders: (state) => (parent) => {
        return state.folders.filter((folder) => {
            return parent.id === folder.parent
        })
    },

    parentFolders: (state) => state.parents,

    /**
     * Returns child items of the active folder.
     * @param state
     */
    childItems: state => state.items,

    /**
     * Is currently loading.
     * @param state
     */
    isLoading: state => state.loading,

    /**
     * Returns the active item.
     * @param state
     */
    activeItem: state => state.item,

    isCreating: state => state.creating
};

const actions = {
    /**
     * Get all folders from the server.
     * @param commit
     * @param dispatch
     */
    getFolders ({ commit, dispatch }) {
        dispatch('isLoading', true);
        getFolders(folders => {
            commit(types.MEDIA_FOLDERS_GET, { folders });

            // Get the root folder.. Change this!
            let folder = folders[0];
            commit(types.MEDIA_FOLDERS_ROOT, folder);
            dispatch('selectFolder', folder)
        })
    },

    /**
     * Select a folder to become the active folder.
     * @param commit
     * @param dispatch
     * @param folder
     */
    selectFolder ({ commit, dispatch }, folder) {
        commit(types.MEDIA_FOLDERS_SELECT, { folder });
        dispatch('isLoading', true);
        dispatch('getItems')
    },

    /**
     * Get all items from the active folder.
     * @param state
     * @param commit
     * @param dispatch
     */
    getItems ({ state, commit, dispatch }) {
        dispatch('isLoading', true);
        getItems(state.folder, items => {
            commit(types.MEDIA_ITEMS_GET, { items });
            dispatch('isLoading', false)
        })
    },

    /**
     * Search items with the supplied query.
     * @param commit
     * @param dispatch
     * @param searchQuery
     */
    searchItems ({ commit, dispatch }, searchQuery) {
        dispatch('isLoading', true);
        searchItems(searchQuery, items => {
            commit(types.MEDIA_ITEMS_GET, { items });
            dispatch('isLoading', false)
        })
    },

    /**
     * Set the loading state.
     * @param commit
     * @param loading
     */
    isLoading ({ commit }, loading) {
        commit(types.MEDIA_LOADING, loading);
        if (loading) {
            commit(types.MEDIA_ITEMS_CLEAR);
        }
    },

    /**
     * Select an item.
     * @param commit
     * @param item
     */
    selectItem ({ commit }, item) {
        commit(types.MEDIA_ITEMS_SELECT, item)
    },

    storeFolder({ commit, dispatch }, { parentId, name }) {
        commit(types.MEDIA_LOADING, true);
        commit(types.MEDIA_FOLDERS_STORE);
        storeFolder(parentId, name, folder => {
            commit(types.MEDIA_FOLDERS_STORE, folder);
            dispatch('isLoading', false)
        }, folder => {
            dispatch('isLoading', false)
        })
    }
};

const mutations = {

    [types.MEDIA_FOLDERS_ROOT] (state, folder) {
        state.root = folder
    },

    /**
     * Store folders in to the folders state.
     * @param state
     * @param folders
     */
    [types.MEDIA_FOLDERS_GET] (state, { folders }) {
        state.folders = folders
    },

    /**
     * Update the folder state with a new folder.
     * @param state
     * @param folder
     */
    [types.MEDIA_FOLDERS_SELECT] (state, { folder }) {

        state.folder = folder;

        let parentFolders = [];

        while (folder.parent !== undefined && folder.parent !== 0) {

            folder = state.folders.find((item) => {
                return folder.parent === item.id
            });

            parentFolders.push(folder.id);
        }

        state.parents = parentFolders
    },

    /**
     * Store items in to the items state.
     * @param state
     * @param items
     */
    [types.MEDIA_ITEMS_GET] (state, { items }) {
        state.items = items
    },

    /**
     * Clear all items.
     * @param state
     */
    [types.MEDIA_ITEMS_CLEAR] (state) {
        state.items = []
    },

    /**
     * Set the loading state.
     * @param state
     * @param loading
     */
    [types.MEDIA_LOADING] (state, loading) {
        state.loading = loading
    },

    /**
     * Set the active item.
     * @param state
     * @param item
     */
    [types.MEDIA_ITEMS_SELECT] (state, item) {
        state.item = item
    },

    [types.MEDIA_FOLDERS_STORE] (state, folder) {

        if (folder === undefined) {
            state.creating = true;
            return true;
        }

        state.creating = false;
        state.folders.unshift(folder)
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
