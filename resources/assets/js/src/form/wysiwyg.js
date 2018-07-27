export const CKEDITOR_CONFIG = {
    language: 'en-gb',
    customConfig: '',
    filebrowserBrowseUrl: '/admin/media/modal/all',
    toolbar: [
        [
            'Format',
            'Styles',
            'TextColor',
            '-',
            'Bold',
            'Italic',
            'RemoveFormat',
            '-',
            'NumberedList',
            'BulletedList',
            '-',
            'Link',
            'Unlink',
            '-',
            'JustifyLeft',
            'JustifyCenter',
            'JustifyRight',
            '-',
            'Image',
            'Blockquote',
            '-',
            'Source',
            'Maximize'
        ]
    ],
    height: 150,
    format_tags: 'p;h1;h2;h3;h4',
    extraAllowedContent: 'iframe[*]',
    colorButton_colors: '',
    colorButton_enableAutomatic: false,
    colorButton_enableMore: false,
    contentCss: '', // iframe styles
    stylesSet: [],
    extraPlugins: 'stylesheetparser'
}

let textareas = []

export function createEditors (context = document) {
    const textareaEls = context.querySelectorAll('.js-wysiwyg')

    const baseConfig = setupGlobalConfig()
    return Array.from(textareaEls).map(el => createEditor(el, baseConfig))
}

export function createEditor (el, baseConfig) {
    let config = getElementConfig(el, baseConfig)

    const editor = CKEDITOR.replace(el, config)
    textareas.push(editor)
    return editor
}

function getElementConfig (el, config) {
    let elConfig = {}
    const {
        formatTags,
        colors,
        stylesSet,
        extraAllowedContent,
        toolbar
    } = el.dataset

    const removeToolbarItems = []

    if (formatTags) {
        elConfig.format_tags = formatTags
    }

    if (colors) {
        if (colors === 'false') {
            removeToolbarItems.push('TextColor')
        } else {
            elConfig.colorButton_colors = colors
        }
    }

    if (stylesSet) {
        if (stylesSet === 'false') {
            removeToolbarItems.push('Styles')
        } else {
            elConfig.stylesSet = JSON.parse(stylesSet)
        }
    }

    if (extraAllowedContent) {
        elConfig.extraAllowedContent = extraAllowedContent
    }

    if (toolbar) {
        elConfig.toolbar = JSON.parse(toolbar)
    }

    config = Object.assign(config, elConfig)
    if (removeToolbarItems.length) {
        config.toolbar[0] = config.toolbar[0].filter(
            item => !~removeToolbarItems.indexOf(item)
        )
    }

    return config
}

export function updateAllElements () {
    textareas.forEach(el => {
        el.updateElement()
    })
}

function setupGlobalConfig () {
    let config = window.wysiwygConfig || {}
    return Object.assign(CKEDITOR_CONFIG, config)
}

export function removeEditor (el) {
    textareas = textareas.filter(editor => editor !== el)
    el.destroy()
}
