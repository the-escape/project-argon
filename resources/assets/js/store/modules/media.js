import mediaApi from '../../api/media'
import * as types from '../mutation-types'

const state = {
    /**
     * The active folder.
     */
    folder: {},

    /**
     * An array of all folders.
     */
    folders: []
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
    }
};

const actions = {
    /**
     * Get all folders from the server.
     * @param commit
     */
    getFolders ({ commit }) {
        mediaApi.getFolders(folders => {
            commit(types.MEDIA_FOLDERS_GET, { folders });

            // Get the root folder.. Change this!
            let folder = folders[0];
            commit(types.MEDIA_FOLDERS_SELECT, { folder })
        })
    },

    /**
     * Select a folder to become the active folder.
     * @param commit
     * @param folder
     */
    selectFolder ({ commit }, folder) {
        commit(types.MEDIA_FOLDERS_SELECT, { folder })
    }
};

const mutations = {
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
        state.folder = folder
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
