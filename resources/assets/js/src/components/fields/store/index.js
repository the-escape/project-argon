import Vuex from 'vuex'
import { createUniqueHash, deepClone } from '../../../util'
import { preventPageLeave } from '../../../ui'

export function getStore () {
    return new Vuex.Store({
        state: {
            fields: [],
            oldState: [],
            header: ''
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

            setOldState (state) {
                state.oldState = deepClone(state.fields)
            },

            restoreOldState (state) {
                state.fields = deepClone(state.oldState)
            },

            setHeader (state, { header }) {
                state.header = header
            },

            // Field Mutations
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
                preventPageLeave()
            },
            updateValues (state, { fieldID, newValues }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== fieldID) {
                        return field
                    }

                    field.values = newValues
                    return field
                })
                preventPageLeave()
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
                preventPageLeave()
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
                preventPageLeave()
            },

            // Combo Item Mutations
            updateComboItemValues (state, { comboID, newValues }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = newValues
                    return field
                })
                preventPageLeave()
            },
            addComboItemValue (state, { comboID, newValueObj }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    newValueObj = Object.keys(newValueObj).reduce(
                        (acc, fieldID) => {
                            if (fieldID === 'id') {
                                return acc
                            }

                            acc[fieldID] = newValueObj[fieldID].map(value =>
                                Object.assign(value, {
                                    id: createUniqueHash()
                                })
                            )
                            return acc
                        },
                        {}
                    )

                    field.values.push(
                        Object.assign(newValueObj, { id: field.values.length })
                    )
                    return field
                })
                preventPageLeave()
            },
            removeComboItem (state, { comboID, comboItemID }) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = field.values.filter(
                        valueObj => valueObj.id !== comboItemID
                    )
                    return field
                })
                preventPageLeave()
            },

            // Combo Field Mutations
            updateComboFieldValue (
                state,
                { fieldID, comboID, comboItemId, newValue }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = field.values.map(valuesObj => {
                        if (valuesObj.id !== comboItemId) {
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
                preventPageLeave()
            },
            updateComboFieldValues (
                state,
                { fieldID, comboID, comboItemId, newValues }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values.map(valuesObj => {
                        if (valuesObj.id !== comboItemId) {
                            return valuesObj
                        }

                        valuesObj[fieldID] = newValues
                        return valuesObj
                    })
                    return field
                })
                preventPageLeave()
            },
            addComboFieldValue (
                state,
                { fieldID, comboID, comboItemId, valueObj }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = field.values.map(valuesObj => {
                        if (valuesObj.id !== comboItemId) {
                            return valuesObj
                        }

                        valuesObj[fieldID].push(
                            Object.assign(valueObj, { id: createUniqueHash() })
                        )
                        return valuesObj
                    })
                    return field
                })
                preventPageLeave()
            },
            removeComboFieldValue (
                state,
                { fieldID, comboID, comboItemId, valueID }
            ) {
                state.fields = state.fields.map(field => {
                    if (field.id !== comboID) {
                        return field
                    }

                    field.values = field.values.map(valuesObj => {
                        if (valuesObj.id !== comboItemId) {
                            return valuesObj
                        }

                        valuesObj[fieldID] = valuesObj[fieldID].filter(
                            value => value.id !== valueID
                        )
                        return valuesObj
                    })
                    return field
                })
                preventPageLeave()
            }
        }
    })
}
