import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'
import { confirm } from '../confirm-btns'
import { createUniqueHash } from '../../util'
import dragula from 'dragula'

import {
    initialiseFormElementsForNewElement,
    refreshFromElements
} from '../../form'

const Multiple = {
    el: null,
    track: null,
    itemTemplate: null,
    addItemCB: null,
    data: null,

    items: null,
    drag: null
}

function exampleCB() {
    return new Promise(resolve => {
        // spawn modal
        resolve('resolved value');ƒ
    })
}

export function createMultiples (context = document) {
    const multipleEls = context.querySelectorAll('.js-multi')
    let multiples = Array.from(multipleEls)
    multiples = multiples.map(el => createMultiple(el))
    return multiples
}

export function createMultiple (el, values = [], data = {}) {
    const Obj = Object.create(Multiple)
    init.call(Obj, el, values, data)
    return Obj
}

function init (el, values, data) {
    if (typeof el === 'string') {
        this.el = document.querySelector(el)
    } else {
        this.el = el
    }

    if (!this.el) {
        return
    }

    this.track = this.el.querySelector('.js-multi-track')
    this.itemTemplate = this.track.innerHTML
    this.track.innerHTML = ''
    this.items = []
    this.data = data
    this.addItemCB = data.addItemCB

    setupEvents.call(this)
    setupItems.call(this, values)
}



function setupEvents () {
    fromEvent(this.el, 'click')
        .pipe(
            filter(evt => evt.target.classList.contains('js-multi-add')),
            map(evt => {
                evt.preventDefault()
                return evt
            })
        )
        .subscribe(() => addItemCB.call(this, ''))

    this.drag = dragula([this.track], {
        revertOnSpill: true,
        removeOnSpill: false,
        moves: (el, container, handle) =>
            handle.classList.contains('js-multi-drag')
    })

    this.drag.on('drop', el => {
        const formElements = getformElementsFromMultiEl.call(this, el)
        refreshFromElements(el, formElements)
    })
}

function setupItems (data) {
    data.forEach(values => {
        addItem.call(this, values)
    })

    if (!data.length) {
        addItem.call(this)
    }
}

function addItemCB(value = ''){
    if(!this.addItemCB){
        addItem.call(this, value)
        return
    }

    this.addItemCB()
        .then(values => {
            const valueKeys = Object.keys(values)
            const dataName = this.data.dataName
            return valueKeys.reduce((acc, key) => {
                acc[dataName + '-' + key] = values[key]
                return acc
            }, {})
        })
        .then(addItem.bind(this))
}

function addItem (value = '') {
    const html = getTemplateHtml.call(this)
    let newItem = this.track.appendChild(html)

    if (typeof value === 'object') {
        const dataNames = Object.keys(value)
        if (dataNames.length) {
            dataNames.forEach(dataName => {
                newItem.querySelector(`[data-name="${dataName}"]`).value =
                    value[dataName]
            })
        }
    } else {
        newItem.querySelector('input, textarea').value = value
    }

    newItem = initialiseItem.call(this, newItem)
    this.items.push(newItem)
}

function getTemplateHtml () {
    const div = document.createElement('div')
    const hash = createUniqueHash()
    const html = this.itemTemplate.replace(/{multiHash}/g, hash)
    div.innerHTML = html

    // to remove
    const input = div.querySelector('input, textarea')
    if (input.dataset.class) {
        input.classList.add(input.dataset.class)
    }

    return div.firstElementChild
}

function initialiseItem (item) {
    const comfirmBtns = item.querySelector('.js-confirm')
    confirm(
        comfirmBtns,
        duplicateItem.call(this, item),
        removeItem.call(this, item)
    )
    return initialiseFormElementsForNewElement(item)
}

function duplicateItem (item) {
    return () => {
        const inputs = item.querySelectorAll('input, textarea')
        let inputValues

        if (inputs.length === 1) {
            inputValues = inputs[0].value
        } else {
            inputValues = Array.from(inputs).reduce((acc, input) => {
                const name = input.dataset.name
                acc[name] = input.value
                return acc
            }, {})
        }
        addItem.call(this, inputValues)
    }
}

function removeItem (item) {
    return () => {
        this.items = this.items.filter(multiItem => multiItem !== item)
        item.remove()
    }
}

function getformElementsFromMultiEl (item) {
    const multiItem = this.items.filter(multiItem => multiItem.el === item)
    if (!multiItem.length) {
        return
    }

    return multiItem[0].formElements
}
