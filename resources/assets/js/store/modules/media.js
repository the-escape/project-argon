import { getFolders, getItems, searchItems } from '../../api/media'
import * as types from '../mutation-types'

const state = {
    loading: false,

    /**
     * The active folder.
     */
    folder: {},

    /**
     * An array of all folders.
     */
    folders: [],

    /**
     * An array of items in the active folder.
     */
    items: [],

    /**
     * Current selected item.
     */
    item: {}
};

const getters = {
    /**
     * Returns the active folder.
     * @param state
     */
    activeFolder: state => state.folder,

    /**
     * Returns all folders.
     * @param state
     */
    allFolders: state => state.folders,

    /**
     * Returns child folders of the active folder.
     * @param state
     * @returns {Array.<*>}
     */
    childFolders: state => {
        return state.folders.filter((folder) => {
            return folder.parent === state.folder.id
        })
    },

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
    activeItem: state => state.item
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
    }
};

const mutations = {
    /**
     * Store folders in to the folders state.
     * @param state
     * @param folders
     */
    [types.MEDIA_FOLDERS_GET] (state, { folders }) {
        state.folders = folders;
    },

    /**
     * Update the folder state with a new folder.
     * @param state
     * @param folder
     */
    [types.MEDIA_FOLDERS_SELECT] (state, { folder }) {
        state.folder = folder
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
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
