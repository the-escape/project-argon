import media from '../../api/media'
import * as types from '../mutation-types'

const state = {
    folder: {},
    folders: []
}

const getters = {
    folder: state => state.folder,
    folders: state => state.folders
}

const actions = {
    getAllFolders ({ commit }) {
        media.getFolders(folders => {
            commit(types.MEDIA_FOLDERS_REQUEST, { folders })

            // Get the root folder.. Make this secure!
            let folder = folders[0]

            commit(types.MEDIA_FOLDERS_SELECT, { folder })
        })
    },
    selectFolder ({ commit }, folder) {
        commit(types.MEDIA_FOLDERS_SELECT, { folder })
    }
}

const mutations = {
    [types.MEDIA_FOLDERS_SELECT] (state, { folder }) {
        state.folder = folder
    },
    [types.MEDIA_FOLDERS_REQUEST] (state, { folders }) {
        state.folders = folders
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
