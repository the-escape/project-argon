import { createUniqueHash } from '../../../../util'
import Vue from 'vue'

export const fieldMutations = {
    updateValue (state, { groupID, id, newValue }) {
        if (!state.values[groupID] || !state.values[groupID][id]) {
            return
        }

        const newStateValues = Object.assign({}, state.values)
        newStateValues[groupID][id] = newStateValues[groupID][id].map(value => {
            if (value.id !== newValue.id) {
                return value
            }

            return Object.assign({}, value, newValue)
        })

        state.values = newStateValues
    },

    updateValues (state, { groupID, id, newValues }) {
        if (!state.values[groupID] || !state.values[groupID][id]) {
            return
        }

        Vue.set(state.values[groupID], id, newValues)
    },

    addValue (state, { groupID, id, valueObj }) {
        if (!state.values[groupID]) {
            return
        }

        const newStateValues = Object.assign({}, state.values)
        const newValue = Object.assign({}, valueObj, { id: createUniqueHash() })

        if (!newStateValues[groupID][id]) {
            newStateValues[groupID][id] = [newValue]
        } else {
            newStateValues[groupID][id].push(newValue)
        }

        state.values = newStateValues
    },

    removeValue (state, { groupID, id, valueID }) {
        if (!state.values[groupID] || !state.values[groupID][id]) {
            return
        }

        state.values[groupID][id] = state.values[groupID][id].filter(value => value.id !== valueID)
    }
}

export const fieldGetters = {
    getField: state => (groupID, [fieldID, comboID = null]) => {
        let parent = state.groupOptions[groupID]
        if (comboID) {
            parent = state.groupOptions[groupID].fields.find(field => field.id === comboID)
        }

        if (!parent) {
            return
        }

        return parent.fields.find(field => field.id === fieldID)
    },
    getFieldOption: (state, getters) => (groupID, [fieldID, comboID = null], option) => {
        const field = getters.getField(groupID, [fieldID, comboID])
        if (field) {
            const optionPath = option.split('.')
            return optionPath.reduce((acc, path) => {
                if (!acc) {
                    return
                }
                if (acc[path]) {
                    return acc[path]
                }
            }, field.options)
        }
    },
    getFieldErrors: state => (groupID, [fieldID, comboID = null, comboItemID = null]) => {
        if (comboID) {
            const comboErrors = state.errors[groupID][comboID]

            if (comboErrors.length) {
                const errors = comboErrors.filter(errorsObj => errorsObj.id === comboItemID)
                if (errors.length && errors[0][fieldID]) {
                    return errors[0][fieldID]
                }
            }
            return []
        } else {
            return state.errors[groupID][fieldID]
        }
    },
    getValues: state => (groupID, [fieldID, comboID = null, comboItemID = null]) => {
        if (comboID) {
            const comboValues = state.values[groupID][comboID]

            if (comboValues.length) {
                const values = comboValues.find(value => value.id === comboItemID)
                if (values && values[fieldID]) {
                    return values[fieldID]
                }
            }
            return [{ id: 0 }]
        } else {
            const fieldValues = state.values[groupID][fieldID]

            if (!fieldValues) {
                return []
            }

            return fieldValues
        }
    },
    getSingleValue: (state, getters) => (groupID, [fieldID, comboID = null, comboItemID = null]) => {
        const values = getters.getValues(groupID, [fieldID, comboID, comboItemID])

        if (!values.length) {
            return
        }

        return values[0]
    }
}
