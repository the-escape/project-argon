import Vuex from 'vuex'
import { createUniqueHash } from '../../util'

export function getStore () {
    return new Vuex.Store({
        state: {
            fields: []
        },
        getters: {
            getField: state => id => {
                const field = state.fields.filter(field => field.id === id)
                if (field.length) {
                    return field[0]
                }
            },
            getComboField: state => (comboID, fieldID) => {
                const comboItem = state.fields.filter(
                    field => field.id === comboID
                )
                if (comboItem.length) {
                    const field = comboItem[0].fields.filter(
                        field => field.id === fieldID
                    )
                    if (field.length) {
                        return field[0]
                    }
                }
            }
        },
        mutations: {
            setFields (state, { fields }) {
                state.fields = fields
            },
            updateComboItemValue (
                state,
                { fieldID, comboID, comboValueId, newValue }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = field.values.map(valuesObj => {
                        if (valuesObj.id !== comboValueId) {
                            return valuesObj
                        }

                        valuesObj[fieldID] = valuesObj[fieldID].map(value => {
                            if (value.id !== newValue.id) {
                                return value
                            }

                            value = Object.assign(value, newValue)
                            return value
                        })

                        return valuesObj
                    })

                    return field
                })
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
            updateComboValues (state, { comboID, newValues }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = newValues
                    return field
                })
            },
            updateComboItemValues (
                state,
                { fieldID, comboID, comboValueId, newValues }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values.map(valuesObj => {
                        if (valuesObj.id !== comboValueId) {
                            return valuesObj
                        }

                        valuesObj[fieldID] = newValues
                        return valuesObj
                    })
                    return field
                })
            },
            updateValues (state, { fieldID, newValues }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== fieldID) {
                        return field
                    }

                    field.values = newValues
                    return field
                })
            },
            addComboItemValue (
                state,
                { fieldID, comboID, comboValueId, valueObj }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = field.values.map(valuesObj => {
                        if (valuesObj.id !== comboValueId) {
                            return valuesObj
                        }

                        valuesObj[fieldID].push(
                            Object.assign(valueObj, { id: createUniqueHash() })
                        )
                        return valuesObj
                    })
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
            removeComboItemValue (
                state,
                { fieldID, comboID, comboValueId, valueID }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = field.values.map(valuesObj => {
                        if (valuesObj.id !== comboValueId) {
                            return valuesObj
                        }

                        valuesObj[fieldID] = valuesObj[fieldID].filter(
                            value => value.id !== valueID
                        )
                        return valuesObj
                    })
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
