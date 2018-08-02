import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'
import dragula from 'dragula'
import { createMultiple } from './multi'

import {
    initialiseFormElementsForNewElement,
    refreshFromElements
} from '../../form'
import { confirm } from '../confirm-btns'
import { Jump } from '..'

import { templates, areTemplatesSet, setupTemplates } from './templates'

import { setInputTypeData, parseTemplate } from './template-input-types'

const Combo = {
    el: null,
    templates: null,
    track: null,

    id: null,
    data: null,
    orderNum: null, // part of the name combo[${orderNum}]
    items: null,
    drag: null,
    moving: false,
    isMultiple: true,
    name: null,
    comboName: null
}

let comboCount = 0
let hashes = []

export function combos () {
    const comboEls = document.querySelectorAll('.js-combo')
    let combos = Array.from(comboEls)
    combos = combos.map(el => combo(el))
    return combos
}

export function combo (el, data = null, template = null) {
    const Obj = Object.create(Combo)
    if (!areTemplatesSet) {
        setupTemplates()
    }
    init.call(Obj, el, comboCount, data, templates)
    comboCount += 1
    return Obj
}

function init (el, comboNumber, data = null, templates = null) {
    if (!el) {
        return
    }

    this.el = el
    if (data) {
        this.id = data.id
        this.data = data
    } else {
        this.id = this.el.dataset.id

        if (!window.combos || !window.combos[this.id]) {
            return
        }

        this.data = window.combos[this.id]
    }

    this.name = this.data.options.name
    this.comboName = this.data.options.comboAddName || 'Item'
    this.isMultiple = this.data.options.settings.multiple
    this.templates = templates
    this.track = this.el.querySelector('.js-combo-track')
    this.orderNum = comboNumber
    this.items = []

    if (this.el.classList.contains('o-combo--moving')) {
        this.moving = true
    }

    setupEvents.call(this)
    setupItems.call(this)
}

function setupEvents () {
    const click = fromEvent(this.el, 'click')

    click
        .pipe(filter(evt => evt.target.classList.contains('js-combo-add')))
        .subscribe(() => addItem.call(this))

    click
        .pipe(filter(evt => evt.target.classList.contains('js-combo-drag')))
        .subscribe(evt => {
            if (this.el.classList.contains('o-combo--moving')) {
                this.el.classList.remove('o-combo--moving')
                this.moving = false
                scrollToComboItem(evt.target)
            } else {
                this.el.classList.add('o-combo--moving')
                this.moving = true
            }
        })

    this.drag = dragula([this.track], {
        revertOnSpill: true,
        removeOnSpill: false,
        moves: (el, container, handle) =>
            handle.classList.contains('js-combo-drag') && this.moving
    })

    this.drag.on('drop', el => {
        const formElements = getformElementsFromComboEl.call(this, el)
        refreshFromElements(el, formElements)
    })
}

function setupItems () {
    this.data.values.forEach(comboValues => {
        addItem.call(this, comboValues)
    })
}

function addItem (values) {
    const { el, hash } = getComboHtml.call(this, values)
    const newComboItem = this.track.appendChild(el)
    setupMulti.call(this, newComboItem, values)
    newComboItem.querySelector('.js-combo-title').dataset.no =
        this.items.length + 1
    const formElements = initialiseItem.call(this, newComboItem, hash)
    this.items.push({
        el: newComboItem,
        hash,
        formElements
    })
}

function removeItem (combo) {
    return () => {
        this.items = this.items.filter(item => item !== combo)
        combo.remove()
    }
}

function duplicateItem (combo, hash) {
    return () => {
        const comboValues = getComboItemValues(combo)
        addItem.call(this, comboValues)
    }
}

function initialiseItem (item, hash) {
    const comfirmBtns = item.querySelector('.js-confirm')
    confirm(
        comfirmBtns,
        duplicateItem.call(this, item, hash),
        removeItem.call(this, item)
    )
    return initialiseFormElementsForNewElement(item)
}

function getComboHtml (values) {
    let html
    let hash = createUniqueHash()

    html = this.data.fields.reduce((acc, field) => {
        let fieldValue
        if (values) {
            fieldValue = values[field.id]
        }

        const templateData = setInputTypeData(field, this.templates, fieldValue)

        templateData.inputName = `combo[${this.id}][${hash}]${
            templateData.inputName
        }`

        templateData.dataName = field.id

        html = parseTemplate(templateData.html, templateData, this.templates)

        acc += html
        return acc
    }, '')

    html = this.templates.comboItemTop + html + this.templates.comboItemBot

    const div = document.createElement('div')
    div.innerHTML = html

    return {
        el: div.firstElementChild,
        hash
    }
}

function createUniqueHash () {
    let newHash = createHash()
    while (~hashes.indexOf(newHash)) {
        newHash = createHash()
    }

    hashes.push(newHash)
    return newHash
}

function createHash () {
    return Math.random()
        .toString(36)
        .substr(2, 9)
}

function getComboItemValues (comboEl) {
    const groupEls = comboEl.querySelectorAll('[data-input-id]')
    const groups = Array.from(groupEls)

    const values = groups.reduce((acc, group) => {
        const inputID = group.dataset.inputId
        const inputEls = group.querySelectorAll('[data-name]')
        let inputs = Array.from(inputEls)
        inputs = inputs.reduce((inputAcc, el) => {
            let value
            value = el.value

            if (typeof el.dataset.jsonValue !== 'undefined') {
                value = JSON.parse(value)
            }

            // if (el.tagName === 'SELECT') {
            //     value = [...el.options]
            //         .filter(option => option.selected)
            //         .map(option => option.value)
            //     value = JSON.stringify(value)
            // } else {
            //     value = el.value
            // }

            // const nameParts = el.name.split('-')
            // if (nameParts[1] === 'toggleValue' && el.value === '1') {
            //     inputAcc[nameParts[0] + '-toggleChecked'] = 'checked'
            // } else {
            //     inputAcc[name] = value
            // }

            if (Array.isArray(value)) {
                return [...inputAcc, ...value]
            } else {
                inputAcc.push(value)
                return inputAcc
            }
        }, [])

        acc[inputID] = inputs
        return acc
    }, {})

    return values
}

function getformElementsFromComboEl (combo) {
    const item = this.items.filter(item => item.el === combo)
    if (!item.length) {
        return
    }

    return item[0].formElements
}

function scrollToComboItem (el) {
    requestAnimationFrame(() => {
        Jump.jump(el)
    })
}

function setupMulti (newComboItem, comboValues) {
    this.data.fields.forEach(field => {
        if (!field.options.settings.multiple) {
            return
        }

        const group = newComboItem.querySelector(
            `[data-input-id="${field.id}"]`
        )
        const multiEl = group.querySelector('.js-multi')
        let values = []
        if (comboValues && comboValues[field.id]) {
            values = comboValues[field.id]
        }
        createMultiple(multiEl, values)
    })
}
