import { assignNewIdsToComboValueObj, getCombo } from './util'
import { createUniqueHash } from '../../../../../util'

// const fieldsExample = [
//     {
//         id: 2,
//         options: {
//             typeKey: 'combo',
//             name: 'Multi Combo',
//             settings: { multiple: true }
//         },
//         helpText: '',
//         message: '',
//         messageAfter: '',
//         fields: [
//             {
//                 id: 3,
//                 options: {
//                     typeKey: 'text',
//                     name: 'single text',
//                     settings: {
//                         required: false,
//                         multiline: false,
//                         multiple: false,
//                         minlength: 0,
//                         maxlength: 0,
//                         url: false,
//                         integer: false,
//                         float: false,
//                         email: false,
//                         phone: false
//                     }
//                 },
//                 helpText: '',
//                 message: '',
//                 messageAfter: ''
//             }
//         ],
//         values: [{ '3': { id: 0, value: 'two' } }],
//         errors: []
//     }
// ]

export const comboMutations = {
    // Combo - Item
    // Other 2 crud are actions that resuse field mutations
    addComboItemValue (state, { groupID, id, valueObj }) {
        const combo = getCombo(state.groups[groupID], id, `Can't add values`)
        if (!combo) {
            return
        }

        const newValueObj = assignNewIdsToComboValueObj(valueObj)
        newValueObj.id = combo.values.length
        combo.values.push(newValueObj)
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
        const combo = getCombo(
            state.groups[groupID],
            comboID,
            `Can't update combo item`
        )
        if (!combo) {
            return
        }

        const comboItemValues = combo.values.find(
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
        const combo = getCombo(
            state.groups[groupID],
            comboID,
            `Can't add combo item field`
        )
        if (!combo) {
            return
        }

        const comboItemValues = combo.values.find(
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
        const combo = getCombo(
            state.groups[groupID],
            comboID,
            `Can't remove combo item field`
        )
        if (!combo) {
            return
        }

        const comboItemValues = combo.values.find(
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
