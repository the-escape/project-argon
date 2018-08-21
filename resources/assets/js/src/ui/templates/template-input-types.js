import { spawnMediaLibModalForFile, spawnMediaLibModalForImage } from '../../form/media-input'
import { createUniqueHash } from '../../util'

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
        data.multi = true
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
    } else {
        data.inputName += '[]'
        data.value = data.values[0] || ''
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
        data.isMultiple = ''
        data.inputName += '[]'
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
        if (~data.values.indexOf(key)) {
            selected = ' selected'
        }
        return `<option value="${key}"${selected}>${value}</option>`
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

function datetime (data, templates) {
    data.input = templates.datetime
    data.time = data.time ? 'true' : 'false'
    data.default = data.default ? 'true' : 'false'
    data.range = data.range ? 'true' : 'false'

    data.value = data.values[0] || ''
    return data
}

function item (data, templates) {
    if (data.multiple_instances) {
        data.inputName += '[]'
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
        return data
    }

    data.isMultiple = ''
    if (data.multiple) {
        data.isMultiple = 'multiple'
    } else {
        data.inputName += '[]'
    }

    data.input = templates.select
    data.options = data.options.reduce((acc, keyVal) => {
        const keys = Object.keys(keyVal)
        keys.forEach(key => {
            acc += selectOption(data, key, keyVal[key])
        })
        return acc
    }, '<option>&nbsp;</option>')

    return data
}

function location (data, templates) {
    data.input = templates.location

    let hash = ''

    if (!data.multiple) {
        hash = createUniqueHash()
        hash = `[${hash}]`
    }

    data.latInputName = data.inputName + `${hash}[latitude]`
    data.lngInputName = data.inputName + `${hash}[longitude]`
    data.latDataName = data.dataName + '-latitude'
    data.lngDataName = data.dataName + '-longitude'
    data.latValue = data.value && data.value.latitude ? data.value.latitude : ''
    data.lngValue = data.value && data.value.longitude ? data.value.longitude : ''

    if (data.multiple) {
        data.multi = true
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
        data.values = data.values.reduce((acc, value) => {
            const keys = Object.keys(value)
            const newValue = {}
            keys.forEach(key => {
                newValue[data.dataName + '-' + key] = value[key]
            })
            acc.push(newValue)
            return acc
        }, [])
    }

    return data
}

function button (data, templates) {

    let hash = ''

    if (!data.multiple) {
        hash = createUniqueHash()
        hash = `[${hash}]`
    }

    data.input = templates.button
    data.labelInputName = data.inputName + `${hash}[label]`
    data.urlInputName = data.inputName + `${hash}[url]`
    data.classInputName = data.inputName + `${hash}[class]`
    data.idInputName = data.inputName + `${hash}[id]`
    data.targetInputName = data.inputName + `${hash}[target]`

    data.labelDataName = data.dataName + '-label'
    data.urlDataName = data.dataName + '-url'
    data.classDataName = data.dataName + '-class'
    data.idDataName = data.dataName + '-id'
    data.targetDataName = data.dataName + '-target'

    data.labelValue = data.value && data.value.label ? data.value.label : ''
    data.urlValue = data.value && data.value.url ? data.value.url : ''
    data.classValue = data.value && data.value.class ? data.value.class : ''
    data.idValue = data.value && data.value.id ? data.value.id : ''
    data.targetValue = data.value && data.value.target ? data.value.target : ''

    if (data.multiple) {
        data.multi = true
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
        data.values = data.values.reduce((acc, value) => {
            const keys = Object.keys(value)
            const newValue = {}
            keys.forEach(key => {
                newValue[data.dataName + '-' + key] = value[key]
            })
            acc.push(newValue)
            return acc
        }, [])
    }

    return data
}

function wysiwyg (data, templates, fieldSettings) {
    data.input = templates.wysiwyg

    let editorSettings = ''

    Object.keys(fieldSettings.editor_options).forEach(function (key) {
        let val = fieldSettings.editor_options[key]
        editorSettings += `data-${key}="${val}" `
    })

    data.inlineProperties = editorSettings;


    if (data.multiple) {
        data.multi = true
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
    } else {
        let hash = createUniqueHash()
        data.inputName += `[${hash}]`
        data.input = data.input.replace('data-class', 'class')
        data.value = data.values[0] || ''
    }

    return data
}

function file (data, templates) {
    data.input = templates.file

    data.addItemCB = spawnMediaLibModalForFile

    data.idDataName = data.dataName + '-id'
    data.urlDataName = data.dataName + '-url'

    data.urlValue = data.value && data.value.url ? data.value.url : ''
    data.idValue = data.value && data.value.id ? data.value.id : ''

    if (data.multiple) {
        data.multi = true
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
        data.values = data.values.reduce((acc, value) => {
            const keys = Object.keys(value)
            const newValue = {}
            keys.forEach(key => {
                newValue[data.dataName + '-' + key] = value[key]
            })
            acc.push(newValue)
            return acc
        }, [])
    } else {
        data.inputName += '[]'
    }

    return data
}

function image (data, templates) {
    data.input = templates.image

    let hash = ''

    if (!data.multiple) {
        hash = createUniqueHash()
        hash = `[${hash}]`
    }

    data.idInputName = data.inputName + `${hash}[id]`
    data.widthInputName = data.inputName + `${hash}[width]`
    data.heightInputName = data.inputName + `${hash}[height]`
    data.altInputName = data.inputName + `${hash}[alt]`
    data.urlInputName = data.inputName + `${hash}[url]`

    data.idDataName = data.dataName + '-id'
    data.widthDataName = data.dataName + '-width'
    data.heightDataName = data.dataName + '-height'
    data.altDataName = data.dataName + '-alt'
    data.urlDataName = data.dataName + '-url'

    data.urlValue = data.value && data.value.url ? data.value.url : ''
    data.idValue = data.value && data.value.id ? data.value.id : ''
    data.widthValue = data.value && data.value.width ? data.value.width : ''
    data.heightValue = data.value && data.value.height ? data.value.height : ''
    data.altValue = data.value && data.value.alt ? data.value.alt : ''

    if (data.multiple) {
        data.multi = true
        data.multiTop = templates.multiTop
        data.multiBot = templates.multiBot
        data.values = data.values.reduce((acc, value) => {
            const keys = Object.keys(value)
            const newValue = {}
            keys.forEach(key => {
                newValue[data.dataName + '-' + key] = value[key]
            })
            acc.push(newValue)
            return acc
        }, [])
    }

    data.addItemCB = spawnMediaLibModalForImage

    return data
}


// ==================
// Common Template functions
// ==================

export function setInputTypeData (field, templates, comboValues = null, comboInputName = null) {
    if (!field.errors) {
        field.errors = []
    }

    if (!field.values) {
        field.values = []
    }

    let data = {
        statusClass: field.errors.length ? 'has-error' : '',
        inputName: `fields[${field.id}]`,
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
        comboAddName: field.options.comboAddName || 'Item',
    }

    if(comboInputName) {
        data.inputName = comboInputName + `[${field.id}]`
    }

    if (comboValues) {
        data.values = comboValues

        if (!data.multiple) {
            data.value = comboValues[0]
        }
    }

    data.label = `<label for="${data.inputName}">${data.name}</label>`

    data = Object.assign(data, field.options.settings)

    if (data.multiple) {
        if (~['image','location','button','wysiwyg'].indexOf(field.options.typeKey)) {
            data.inputName += '[{multiHash}]'
        } else {
            data.inputName += '[]'
        }
    } else {
        if (!comboValues) {
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
        case 'datetime':
            data = datetime(data, templates)
            break
        case 'item':
            data = item(data, templates)
            break
        case 'location':
            data = location(data, templates)
            break
        case 'wysiwyg':
            data = wysiwyg(data, templates, field.options.settings)
            break
        case 'button':
            data = button(data, templates)
            break
        case 'image':
            data = image(data, templates)
            break
        case 'file':
            data = file(data, templates)
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

export function slugify (str, id) {
    return str.toLowerCase().replace(/\s/g, '-') + `${id}`
}
