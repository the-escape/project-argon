import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'
import dragula from 'dragula'

import {
    initialiseFormElementsForNewElement,
    refreshFromElements
} from '../form'
import { confirm } from './confirm-btns'
import { Jump } from '../ui'

const Combo = {
    el: null,
    template: null,
    track: null,

    id: null,
    orderNum: null, // part of the name combo[${orderNum}]
    items: null,
    drag: null,
    moving: false
}

let comboCount = 0
let hashes = []

export function combos () {
    const comboEls = document.querySelectorAll('.js-combo')
    let combos = Array.from(comboEls)
    combos = combos.map(el => combo(el))
    return combos
}

export function combo (el) {
    const Obj = Object.create(Combo)
    init.call(Obj, el, comboCount)
    comboCount += 1
    return Obj
}

function init (el, comboNumber) {
    if (!el) {
        return
    }

    this.el = el
    this.id = this.el.dataset.id
    this.template = this.el.querySelector('.js-combo-template')
    this.template = this.template.innerHTML
    this.track = this.el.querySelector('.js-combo-track')
    this.orderNum = comboNumber
    this.items = []

    if (this.el.classList.contains('js-combo-drag')) {
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
    if (!window.combos || !window.combos[this.id]) {
        return
    }

    window.combos[this.id].forEach(itemValues => {
        addItem.call(this, itemValues)
    })
}

function addItem (values, flattenValues = true) {
    const { el, hash } = getComboHtml.call(this, values, flattenValues)
    const newComboItem = this.track.appendChild(el)
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
        comboValues.hashID = createUniqueHash()

        addItem.call(this, comboValues, false)
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

function getComboHtml (values, flattenValues = true) {
    let html

    let hash
    if (values && values.hashID) {
        hash = values.hashID
    } else {
        hash = createUniqueHash()
    }

    html = this.template.replace(
        /{comboName}/g,
        `combo[${this.orderNum}][${hash}]`
    )

    if (values) {
        let flatValues
        if (flattenValues) {
            flatValues = flattenValueArray(values)
        } else {
            flatValues = values
        }

        const valueKeys = Object.keys(flatValues).filter(
            key => key !== 'hashID'
        )
        html = html.replace(/{\S+}/g, match => {
            match = match.replace(/{|}/g, '')
            if (~valueKeys.indexOf(match)) {
                return flatValues[match]
            }
            return ''
        })
    } else {
        html = html.replace(/{\S+}/g, '')
    }

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

function flattenValueArray (values) {
    const valueKeys = Object.keys(values)
    return valueKeys.reduce((valuesAcc, valueKey) => {
        if (valueKey === 'hashID') {
            return valuesAcc
        }

        const fieldKeys = Object.keys(values[valueKey])

        valuesAcc = fieldKeys.reduce((fieldAcc, fieldKey) => {
            fieldAcc[valueKey + '-' + fieldKey] = values[valueKey][fieldKey]
            return fieldAcc
        }, valuesAcc)

        return valuesAcc
    }, {})
}

function getComboItemValues (comboEl) {
    const inputEls = comboEl.querySelectorAll('[data-name]')
    const inputs = Array.from(inputEls)

    const values = inputs.reduce((acc, el) => {
        const { name } = el.dataset

        let value
        if (el.tagName === 'SELECT') {
            value = [...el.options]
                .filter(option => option.selected)
                .map(option => option.value)
            value = JSON.stringify(value)
        } else {
            value = el.value
        }

        acc[name] = value

        const nameParts = name.split('-')
        if (nameParts[1] === 'toggleValue' && el.value === '1') {
            acc[nameParts[0] + '-toggleChecked'] = 'checked'
        }
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
