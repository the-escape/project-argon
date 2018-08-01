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
    } else {
        data.input = templates.text
    }

    if (data.multiple) {
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
    }
    return data
}

// ==================
// Common Template functions
// ==================

export function setInputTypeData (field, templates) {
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
        multiTop: '',
        multiBot: '',
        message: field.message,
        messageAfter: field.messageAfter,
        value: '',
        errorMessage: field.errors.length ? field.errors[0] : '',
        html: templates.group,
        comboAddName: field.options.comboAddName || 'Item'
    }

    data = Object.assign(data, field.options.settings)

    if (data.multiple) {
        data.inputName = data.inputName + '[]'
    } else if (field.values.length) {
        data.value = field.values[0]
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
