import { processFields } from './util'
import { deepClone } from '../../../../../util'

export const coreMutations = {
    setupGroup (state, { groupID, fields, header, isShowingActions }) {
        state.groups[groupID] = {
            fields: processFields(fields),
            header,
            isShowingActions
        }
    },
    setOldState (state, { groupID }) {
        state.groups[groupID].oldState = deepClone(state.groups[groupID].fields)
    },
    restoreOldState (state, { groupID }) {
        state.groups[groupID].fields = deepClone(state.groups[groupID].oldState)
    }
}

export const coreGetters = {
    groupKeys: state => Object.keys(state.groups),
    fields: state => groupID => state.groups[groupID].fields,
    header: state => groupID => state.groups[groupID].header,
    isShowingActions: state => groupID => state.groups[groupID].isShowingActions
}

export const coreActions = {
    setupGroup ({ commit, state }, { groupID }) {
        if (state.groups[groupID]) {
            return
        }

        let { fields, header, actions = true } = window.fieldGroups[groupID]
        commit('setupGroup', {
            groupID,
            fields,
            header,
            isShowingActions: actions
        })
    }
}
