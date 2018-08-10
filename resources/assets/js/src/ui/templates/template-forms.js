import { initialiseFormElementsForNewElement } from '../../form'
import { createMultiple } from './multi'
import { combo } from './combo'
import { setInputTypeData, parseTemplate } from './template-input-types'
import { areTemplatesSet, templates, setupTemplates } from './templates'

const TemplateForms = {
    el: null,
    groupID: null,
    data: null,
    templates: null
}

export function createTemplateForms (context = document) {
    const templateFormEls = context.querySelectorAll('.js-temple-forms')
    let templateForms = Array.from(templateFormEls)
    setupTemplates()
    templateForms = templateForms.map(el => createTemplateForm(el))
    return templateForms
}

export function createTemplateForm (el) {
    const Obj = Object.create(TemplateForms)
    if (!areTemplatesSet) {
        setupTemplates()
    }
    init.call(Obj, el, templates)
    return Obj
}

function init (el, templates) {
    if (!el) {
        return
    }

    if (!window.fieldGroups) {
        return
    }

    this.el = el
    this.groupID = this.el.dataset.groupId
    this.templates = templates

    if (!window.fieldGroups[this.groupID]) {
        return
    }

    this.data = window.fieldGroups[this.groupID]

    setTemplates.call(this)
    appendTemplates.call(this)
    setupMultiAndCombo.call(this)
}

function setTemplates () {
    this.data.forEach((el, index) => {
        if (this.data[index].options.typeKey !== 'combo') {
            setDataForTemplate.call(this, index)
            setFieldTemplate.call(this, index)
        } else {
            setDataForTemplate.call(this, index)
            setFieldTemplate.call(this, index)

            // this.data[index].fields.forEach((el, comboIndex) => {
            //     setDataForTemplate.call(this, index, comboIndex)
            //     setFieldTemplate.call(this, index, comboIndex)
            // })

            // this.data[index].fieldTemplates =
            //     this.templates.comboItemTop +
            //     this.data[index].fields.reduce((acc, el) => {
            //         acc += el.template
            //         return acc
            //     }, '') +
            //     this.templates.comboItemBot
        }
    })
}

function setDataForTemplate (index, comboIndex = -1) {
    let field = this.data[index]
    if (~comboIndex) {
        field = this.data[index].fields[comboIndex]
    }

    const data = setInputTypeData(field, this.templates)

    if (~comboIndex) {
        this.data[index].fields[comboIndex].data = data
    } else {
        this.data[index].data = data
    }
}

function setFieldTemplate (index, comboIndex = -1) {
    let html = ''
    let data
    if (~comboIndex) {
        html = this.data[index].fields[comboIndex].data.html
        data = this.data[index].fields[comboIndex].data
    } else {
        html = this.data[index].data.html
        data = this.data[index].data
    }

    html = parseTemplate(html, data, this.templates, !!~comboIndex)

    if (~comboIndex) {
        this.data[index].fields[comboIndex].template = html
        return
    }

    this.data[index].template = html
}

function appendTemplates () {
    let groupHtml = this.data.map(el => el.template)
    groupHtml = '<div>' + groupHtml.join('') + '</div>'

    const newGroupHtml = this.el.appendChild(htmlStrToDom(groupHtml))
    initialiseFormElementsForNewElement(newGroupHtml)
}

function htmlStrToDom (str) {
    const div = document.createElement('div')
    div.innerHTML = str
    return div.firstElementChild
}

function setupMultiAndCombo () {
    this.data.forEach(el => {
        if (el.data.multi && el.options.typeKey !== 'combo') {
            const dataName = el.data.dataName
            const multiEl = this.el.querySelector(`[data-input-id=${dataName}]`)
            el.multi = createMultiple(multiEl, el.data.values, el.data)
        }

        if (el.options.typeKey === 'combo') {
            const dataName = el.data.dataName
            const comboEl = this.el.querySelector(`[data-input-id=${dataName}]`)
            combo(comboEl, el, this.templates)
        }
    })
}
