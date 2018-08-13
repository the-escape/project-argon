export let areTemplatesSet = false
export let templates = {
    combo: '.tp-combo',
    comboItemTop: '.tp-combo-item-top',
    comboItemBot: '.tp-combo-item-bot',
    multiTop: '.tp-multi-top',
    multiBot: '.tp-multi-bottom',
    group: '.tp-group',
    description: '.tp-description',
    text: '.tp-text',
    textarea: '.tp-textarea',
    select: '.tp-select',
    selectMultiple: '.tp-select-multiple',
    selectMultipleOption: '.tp-select-multiple-option',
    switch: '.tp-switch',
    datetime: '.tp-datetime',
    location: '.tp-location',
    wysiwyg: '.tp-wysiwyg',
    button: '.tp-button',
    file: '.tp-file',
    image: '.tp-image'
}

export function setupTemplates () {
    if (areTemplatesSet) {
        return
    }

    const templateKeys = Object.keys(templates)
    templateKeys.forEach(key => {
        const templateEl = document.querySelector(templates[key])
        if (!templateEl) {
            console.warn('Cannot find template: ' + key)
            return
        }
        templates[key] = templateEl.innerHTML
    })

    areTemplatesSet = true
}
