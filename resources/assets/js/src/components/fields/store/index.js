import Vuex from 'vuex'
import { createUniqueHash, deepClone } from '../../../util'
import { preventPageLeave } from '../../../ui'

export function getStore () {
    return new Vuex.Store({
        state: {
            fields: [],
            oldState: [],
            header: '',
            showActions: true
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

            setShowActions (state, { actions }) {
                state.showActions = actions
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

                        if (valuesObj[fieldID].length) {
                            valuesObj[fieldID] = valuesObj[fieldID].map(
                                value => {
                                    if (value.id !== newValue.id) {
                                        return value
                                    }

                                    value = Object.assign(value, newValue)
                                    return value
                                }
                            )
                        } else {
                            valuesObj[fieldID].push(newValue)
                        }

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

export function processFields (fields) {
    return fields.map(field => {
        if (field.options.typeKey === 'combo') {
            field = processCombo(field)
        } else {
            field.values = processValues(field.values)
            field.emptyValue = createEmptyValueObj(field)

            if (!field.values.length) {
                const newValue = deepClone(field.emptyValue)
                newValue.id = 0
                field.values.push(newValue)
            }
        }
        return field
    })
}

function processValues (values) {
    if (!Array.isArray(values)) {
        values = [values]
    }

    return values.map((value, id) => ({
        value,
        id
    }))
}

function createEmptyValueObj (field) {
    let emptyValue

    switch (field.options.typeKey) {
    case 'checkbox':
        emptyValue = 0
        break
    case 'location':
        emptyValue = {
            latitude: '',
            longitude: ''
        }
        break
    case 'button':
        emptyValue = {
            label: '',
            url: '',
            class: '',
            id: '',
            target: ''
        }
        break
    default:
        emptyValue = ''
        break
    }

    return {
        value: emptyValue
    }
}

function processCombo (combo) {
    combo.values = combo.values.map((comboItemValues, index) => {
        const fieldIds = Object.keys(comboItemValues)
        const values = fieldIds.reduce((acc, fieldID) => {
            acc[fieldID] = processValues(comboItemValues[fieldID])
            return acc
        }, {})
        values.id = index
        return values
    })

    combo.errors = combo.errors.map((comboItemErrors, index) => {
        comboItemErrors.id = index
        return comboItemErrors
    })

    combo.fields = combo.fields.map(field => {
        field.emptyValue = createEmptyValueObj(field)
        return field
    })

    combo.emptyValue = combo.fields.reduce((acc, field) => {
        acc[field.id] = [field.emptyValue]
        return acc
    }, {})

    return combo
}
