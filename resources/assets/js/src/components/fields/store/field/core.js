import { processFields } from './util'
import { deepClone } from '../../../../util'

export const coreMutations = {
    setUserNameUse (state, { useInputNames }) {
        state.useInputNames = useInputNames
    },
    setupGroup (state, { groupID, fields, header, isShowingActions }) {
        const { fieldOptions, values, errors } = processFields(fields)

        state.groupOptions[groupID] = {
            fields: fieldOptions,
            header,
            isShowingActions
        }
        state.values[groupID] = values
        state.errors[groupID] = errors
    },
    setOldState (state, { groupID }) {
        state.oldValues[groupID] = deepClone(state.values[groupID])
    },
    restoreOldState (state, { groupID }) {
        state.values[groupID] = deepClone(state.oldValues[groupID])
    }
}

export const coreGetters = {
    groupKeys: state => Object.keys(state.groupOptions),
    fields: state => groupID => state.groupOptions[groupID].fields,
    header: state => groupID => state.groupOptions[groupID].header,
    isShowingActions: state => groupID =>
        state.groupOptions[groupID].isShowingActions,
    getFieldValues: state => state.groupOptions // TODO: after another refactor to fields
}

export const coreActions = {
    setupGroup ({ commit, state }, { groupID }) {
        if (state.groupOptions[groupID]) {
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
