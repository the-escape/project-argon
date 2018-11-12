import Vuex from 'vuex'
import { createUniqueHash } from '../../util'

export function getStore () {
    return new Vuex.Store({
        state: {
            fields: []
        },
        getters: {
            getField: state => id => {
                let field = state.fields.filter(field => field.id === id)
                if (field.length) {
                    return field[0]
                }
            }
        },
        mutations: {
            setFields (state, { fields }) {
                state.fields = fields
            },
            updateValue (state, { fieldID, newValue }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== fieldID) {
                        return field
                    }

                    field.values = field.values.map(value => {
                        if (value.id !== newValue.id) {
                            return value
                        }

                        value = Object.assign(value, newValue)
                        return value
                    })
                    return field
                })
            },
            updateValues (state, { fieldID, newVales }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== fieldID) {
                        return field
                    }

                    field.values = newVales
                    return field
                })
            },
            addValue (state, { fieldID, valueObj }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== fieldID) {
                        return field
                    }

                    field.values.push(
                        Object.assign(valueObj, { id: createUniqueHash() })
                    )
                    return field
                })
            },
            removeValue (state, { fieldID, valueID }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== fieldID) {
                        return field
                    }

                    field.values = field.values.filter(
                        value => value.id !== valueID
                    )
                    return field
                })
            }
        }
    })
}
