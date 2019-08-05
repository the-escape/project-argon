import { createUniqueHash } from '../../../../util'
import { getField } from './util'

// const fieldsExample = [
//     {
//         id: 1,
//         options: {
//             typeKey: 'text',
//             name: 'single text',
//             settings: {
//                 required: false,
//                 multiline: false,
//                 multiple: false,
//                 minlength: 0,
//                 maxlength: 0,
//                 url: false,
//                 integer: false,
//                 float: false,
//                 email: false,
//                 phone: false
//             }
//         },
//         helpText: '',
//         message: '',
//         messageAfter: '',
//         values: [{id: 0, value: 'one'}],
//         errors: []
//     }
// ]

export const fieldMutations = {
    updateValue (state, { groupID, id, newValue }) {
        const field = getField(state.groups[groupID], id, `Can't update value`)
        if (!field) {
            return
        }

        field.values = field.values.map(value => {
            if (value.id !== newValue.id) {
                return value
            }

            return Object.assign(value, newValue)
        })
    },

    updateValues (state, { groupID, id, newValues }) {
        const field = getField(state.groups[groupID], id, `Can't update values`)
        if (!field) {
            return
        }

        field.values = newValues
    },

    addValue (state, { groupID, id, valueObj }) {
        const field = getField(state.groups[groupID], id, `Can't add values`)
        if (!field) {
            return
        }

        field.values.push(Object.assign(valueObj, { id: createUniqueHash() }))
    },

    removeValue (state, { groupID, id, valueID }) {
        const field = getField(state.groups[groupID], id, `Can't remove values`)
        if (!field) {
            return
        }

        field.values = field.values.filter(value => value.id !== valueID)
    }
}

export const fieldGetters = {
    getField: state => (groupID, [fieldID, comboID = null]) => {
        let parent = state.groups[groupID]
        if (comboID) {
            parent = state.groups[groupID].fields.find(
                field => field.id === comboID
            )
        }

        if (!parent) {
            return
        }

        return parent.fields.find(field => field.id === fieldID)
    },
    getFieldOption: (state, getters) => (
        groupID,
        [fieldID, comboID = null],
        option
    ) => {
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
    getFieldErrors: (state, getters) => (
        groupID,
        [fieldID, comboID = null, comboItemID = null]
    ) => {
        const field = getters.getField(groupID, [fieldID, comboID])
        if (comboID) {
            if (field.errors.length) {
                const errors = field.errors.filter(
                    errorsObj => errorsObj.id === comboItemID
                )
                if (errors.length && errors[0][fieldID]) {
                    return errors[0][fieldID]
                }
            }
            return []
        }

        return field.errors
    },
    getValues: (state, getters) => (
        groupID,
        [fieldID, comboID = null, comboItemID = null]
    ) => {
        const field = getters.getField(groupID, [fieldID, comboID])

        if (comboID) {
            if (field.values.length) {
                const values = field.values.find(
                    value => value.id === comboItemID
                )
                if (values && values[fieldID]) {
                    return values[fieldID][0]
                }
            }
            return [{ id: 0 }]
        }

        if (!field) {
            return []
        }

        return field.values
    },
    getSingleValue: (state, getters) => (
        groupID,
        [fieldID, comboID = null, comboItemID = null]
    ) => {
        const values = getters.getValues(groupID, [
            fieldID,
            comboID,
            comboItemID
        ])

        if (!values.length) {
            return
        }

        return values[0]
    }
}
