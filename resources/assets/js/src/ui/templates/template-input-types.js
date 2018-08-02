// ==================
// Type Options
// ==================

function text (data, templates) {
    // TODO: sort out text icons
    // options to account for
    // url: 0,
    // integer: 0,
    // float: 0,
    // email: 0,
    // phone: 0

    data.inputIconBefore = ''
    data.inputIconAfter = ''

    if (data.multiline) {
        data.input = templates.textarea
        data.multi = true
    } else {
        data.input = templates.text
    }

    if (data.multiple) {
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
    }
    return data
}

function select (data, templates) {
    if (data.multiple) {
        data.label = ''
        data.input = templates.selectMultiple
        data.options = data.options.reduce((acc, keyVal) => {
            const keys = Object.keys(keyVal)
            keys.forEach(key => {
                acc += selectOption(data, key, keyVal[key], true, templates)
            })
            return acc
        }, '')
        data.value = JSON.stringify(data.values)
    } else {
        data.input = templates.select
        data.options = data.options.reduce((acc, keyVal) => {
            const keys = Object.keys(keyVal)
            keys.forEach(key => {
                acc += selectOption(data, key, keyVal[key])
            })
            return acc
        }, '<option>&nbsp;</option>')
    }

    return data
}

function selectOption (data, key, value, isMultiple = false, templates = null) {
    if (!isMultiple) {
        let selected = ''
        if (data.value === key) {
            selected = ' selected'
        }
        return `<option value="${value}"${selected}>${key}</option>`
    }

    const optionHtml = templates.selectMultipleOption
    return optionHtml.replace(/{key}|{value}/g, match => {
        if (match === '{key}') {
            return key
        }

        if (match === '{value}') {
            return value
        }
    })
}

function boolean (data, templates) {
    data.label = ''
    data.input = templates.switch

    if (!data.values.length) {
        data.value = data['initial_value']
    }

    data.value = parseInt(data.value)

    data.checked = ''
    if (data.value) {
        data.checked = 'checked'
    }
    return data
}

// ==================
// Common Template functions
// ==================

export function setInputTypeData (field, templates, comboValues = null) {
    if (!field.errors) {
        field.errors = []
    }

    if (!field.values) {
        field.values = []
    }

    let data = {
        statusClass: field.errors.length ? 'has-error' : '',
        inputName: `field[${field.id}]`,
        name: field.options.name,
        dataName: slugify(field.options.name, field.id),
        helpText: field.helpText,
        errors: field.errors,
        multi: false,
        multiTop: '',
        multiBot: '',
        message: field.message,
        messageAfter: field.messageAfter,
        value: '',
        values: field.values,
        errorMessage: field.errors.length ? field.errors[0] : '',
        html: templates.group,
        comboAddName: field.options.comboAddName || 'Item'
    }

    if (comboValues) {
        data.values = comboValues
    }

    data.label = `<label for="${data.inputName}">${data.name}</label>`

    data = Object.assign(data, field.options.settings)

    if (data.multiple) {
        data.inputName = data.inputName + '[]'
    } else {
        if (comboValues) {
            data.value = comboValues[0]
        } else if (field.values.length) {
            data.value = field.values[0]
        }
    }

    switch (field.options.typeKey) {
    case 'text':
        data = text(data, templates)
        break
    case 'description':
        data.html = templates.description
        break
    case 'combo':
        data.html = templates.combo
        break
    case 'select':
        data = select(data, templates)
        break
    case 'boolean':
        data = boolean(data, templates)
        break
    }

    return data
}

export function parseTemplate (html, data, templates, skipDataParse = false) {
    const dataKeys = Object.keys(data)
    const dataRegex = new RegExp(
        dataKeys.map(str => `{${str}}`).join('|'),
        'gm'
    )

    // add input to html before parsing rest
    let parsedHtml = html.replace(/{input}/g, () => {
        return data.input
    })

    if (data.message) {
        parsedHtml =
            templates.description.replace(/{content}/g, data.message) +
            parsedHtml
    }

    if (data.messageAfter) {
        parsedHtml += templates.description.replace(
            /{content}/g,
            data.messageAfter
        )
    }

    // skip for combo to handle data parse step
    if (skipDataParse) {
        return parsedHtml
    }

    parsedHtml = parsedHtml.replace(dataRegex, match => {
        return data[match.substr(1, match.length - 2)]
    })

    return parsedHtml
}

function slugify (str, id) {
    return str.toLowerCase().replace(/\s/g, '-') + `${id}`
}
