import { deepClone, createUniqueHash } from '../../../../util'

export function processFields (fields) {
    const fieldOptions = []
    const values = {}
    const errors = {}

    return fields.reduce(
        ({ fieldOptions, values, errors }, field) => {
            let parsedField = []
            let parsedValues = []
            let parsedErrors = []

            if (field.options.typeKey === 'combo') {
                const { combo, values, errors } = processCombo(field)
                parsedField = combo
                parsedValues = values
                parsedErrors = errors
            } else {
                parsedValues = processValues(field.values)
                parsedErrors = field.errors
                field.emptyValue = createEmptyValueObj(field)

                if (!parsedValues.length) {
                    const newValue = deepClone(field.emptyValue)
                    newValue.id = 0
                    parsedValues.push(newValue)
                }

                parsedField = field
            }

            fieldOptions.push(parsedField)
            values[field.id] = parsedValues
            errors[field.id] = parsedErrors
            return {
                fieldOptions,
                values,
                errors
            }
        },
        {
            fieldOptions,
            values,
            errors
        }
    )
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
    let values = combo.values.map((comboItemValues, index) => {
        const fieldIds = Object.keys(comboItemValues)
        const values = fieldIds.reduce((acc, fieldID) => {
            acc[fieldID] = processValues(comboItemValues[fieldID])
            return acc
        }, {})
        values.id = index
        return values
    })

    const errors = combo.errors.map((comboItemErrors, index) => {
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

    values = values.map(value => {
        return Object.assign(combo.emptyValue, value)
    })

    return { combo, values, errors }
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
