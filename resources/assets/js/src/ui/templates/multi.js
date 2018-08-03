import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'
import { confirm } from '../confirm-btns'
import dragula from 'dragula'

import {
    initialiseFormElementsForNewElement,
    refreshFromElements
} from '../../form'

const Multiple = {
    el: null,
    track: null,
    itemTemplate: null,

    items: null,
    drag: null
}

export function createMultiples (context = document) {
    const multipleEls = context.querySelectorAll('.js-multi')
    let multiples = Array.from(multipleEls)
    multiples = multiples.map(el => createMultiple(el))
    return multiples
}

export function createMultiple (el, data = []) {
    const Obj = Object.create(Multiple)
    init.call(Obj, el, data)
    return Obj
}

function init (el, data) {
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

    setupEvents.call(this)
    setupItems.call(this, data)
}

function setupEvents () {
    fromEvent(this.el, 'click')
        .pipe(filter(evt => evt.target.classList.contains('js-multi-add')))
        .subscribe(() => addItem.call(this))

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
    div.innerHTML = this.itemTemplate

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
