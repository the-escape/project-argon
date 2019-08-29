import { deepClone, createUniqueHash } from '../../../../../util'

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

export function assignNewIdsToComboValueObj (valueObj) {
    return Object.keys(valueObj).reduce((acc, fieldID) => {
        if (fieldID === 'id') {
            return acc
        }

        acc[fieldID] = valueObj[fieldID].map(value =>
            Object.assign(value, { id: createUniqueHash() })
        )

        return acc
    }, {})
}

function getHelper (state, id, message) {
    const item = state.fields.find(field => field.id === id)
    if (!item) {
        console.warn(message)
        return
    }

    return item
}

export function getField (state, id, messagePrefix) {
    return getHelper(
        state,
        id,
        `${messagePrefix}, unable find field of ID: ${id}`
    )
}

export function getCombo (state, id, messagePrefix) {
    return getHelper(
        state,
        id,
        `${messagePrefix}, unable find Combo of ID: ${id}`
    )
}
