import { assignNewIdsToComboValueObj } from './util'
import { createUniqueHash } from '../../../../util'

export const comboMutations = {
    // Combo - Item
    // Other 2 crud are actions that resuse field mutations
    addComboItemValue (state, { groupID, id, valueObj }) {
        const comboValues = state.values[groupID][id]
        if (!comboValues || !comboValues.length) {
            return
        }

        const newValueObj = assignNewIdsToComboValueObj(valueObj)
        newValueObj.id = comboValues.length
        comboValues.push(newValueObj)
    },

    // Combo - Item - Field
    updateComboItemFieldValue (
        state,
        {
            groupID,
            ids: [fieldID, comboID, comboItemID],
            newValue
        }
    ) {
        const comboValues = state.values[groupID][comboID]
        if (!comboValues || !comboValues.length) {
            return
        }

        const comboItemValues = comboValues.find(
            comboItemValue => comboItemValue.id === comboItemID
        )
        if (!comboItemValues) {
            console.warn(
                `Can't find combo item for comboID: ${comboID} with combo Item id: ${comboItemID}`
            )
            return
        }

        if (!comboItemValues[fieldID]) {
            console.warn(`Combo Item doesn't have the field id: ${fieldID}`)
            return
        }

        comboItemValues[fieldID] = comboItemValues[fieldID].map(value => {
            if (value.id !== newValue.id) {
                return value
            }

            return Object.assign(value, newValue)
        })
    },
    addComboItemFieldValue (
        state,
        {
            groupID,
            ids: [fieldID, comboID, comboItemID],
            valueObj
        }
    ) {
        const comboValues = state.values[groupID][comboID]
        if (!comboValues || !comboValues.length) {
            return
        }

        const comboItemValues = comboValues.find(
            comboItem => comboItem.id === comboItemID
        )
        if (!comboItemValues) {
            console.warn(
                `Can't find combo item for comboID: ${comboID} with combo Item id: ${comboItemID}`
            )
            return
        }

        comboItemValues[fieldID].push(
            Object.assign(valueObj, { id: createUniqueHash() })
        )
    },
    removeComboItemFieldValue (
        state,
        {
            groupID,
            ids: [fieldID, comboID, comboItemID],
            valueID
        }
    ) {
        const comboValues = state.values[groupID][comboID]
        if (!comboValues || !comboValues.length) {
            return
        }

        const comboItemValues = comboValues.find(
            comboItem => comboItem.id === comboItemID
        )
        if (!comboItemValues) {
            console.warn(
                `Can't find combo item for comboID: ${comboID} with combo Item id: ${comboItemID}`
            )
            return
        }

        if (comboItemValues[fieldID]) {
            console.warn(`Combo Item doesn't have the field id: ${fieldID}`)
            return
        }

        comboItemValues[fieldID] = comboItemValues[fieldID].filter(
            value => value.id !== valueID
        )
    }
}

export const comboActions = {
    updateComboItemValues (context, payload) {
        context.commit('updateValues', payload)
    },
    removeComboItem (context, payload) {
        context.commit('removeValue', payload)
    }
}

export const comboGetters = {
    getCombo: (state, getters) => (groupID, comboID) => {
        return getters.getField(groupID, [comboID])
    },
    getComboItem: (state, getters) => (groupID, comboID, comboItemID) => {
        const combo = getters.getCombo(groupID, comboID)
        return combo.values.find(val => val.id === comboItemID)
    },
    getComboFields: (state, getters) => (groupID, comboID) => {
        const combo = getters.getCombo(groupID, comboID)
        return combo.fields
    },
    isComboMultiple: (state, getters) => (groupID, comboID) => {
        const combo = getters.getCombo(groupID, comboID)
        return combo.options.settings.multiple
    }
}
