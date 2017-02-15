import mediaApi from '../../api/media'
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

    items: []
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

    childItems: state => state.items,

    isLoading: state => state.loading
};

const actions = {
    /**
     * Get all folders from the server.
     * @param commit
     * @param dispatch
     */
    getFolders ({ commit, dispatch }) {
        commit(types.MEDIA_LOADING, true);
        mediaApi.getFolders(folders => {
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
        commit(types.MEDIA_LOADING, true);
        dispatch('getItems')
    },

    getItems ({ state, commit }) {
        commit(types.MEDIA_ITEMS_CLEAR);
        mediaApi.getItems(state.folder, items => {
            commit(types.MEDIA_ITEMS_GET, {items});
            commit(types.MEDIA_LOADING, false)
        })
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

    [types.MEDIA_ITEMS_GET] (state, { items }) {
        state.items = items
    },

    [types.MEDIA_ITEMS_CLEAR] (state) {
        state.items = []
    },

    [types.MEDIA_LOADING] (state, loading) {
        state.loading = loading
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
