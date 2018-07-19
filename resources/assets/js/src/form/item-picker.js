import { fromEvent, merge } from 'rxjs'
import { filter, map } from 'rxjs/operators'

let itemPickers = []
const ItemPicker = {
    el: null,
    btn: null,
    input: null,
    window: null,
    list: null,
    output: null,

    isColor: false,
    svgPath: ''
}

export function createItemPickers (context = document) {
    const itemPickerEls = context.querySelectorAll('.js-item-picker')
    itemPickers = Array.from(itemPickerEls)
    itemPickers = itemPickers.map(el => createItemPicker(el))
    return itemPickers
}

export function createItemPicker (el) {
    const Obj = Object.create(ItemPicker)
    init.call(Obj, el)
    return Obj
}

function init (el) {
    if (typeof el === 'string') {
        this.el = document.querySelector(el)
    } else {
        this.el = el
    }

    if (!this.el) {
        return
    }

    const { color, path } = this.el.dataset

    this.btn = this.el.querySelector('.js-item-picker-btn')
    this.input = this.el.querySelector('.js-item-picker-input')
    this.window = this.el.querySelector('.js-item-picker-window')
    this.list = this.el.querySelector('.js-item-picker-list')
    this.output = this.el.querySelector('.js-item-picker-output')
    this.isColor = color === 'true'
    this.svgPath = path

    if (this.isColor) {
        this.btn.style.backgroundColor = this.input.value
    }

    if (this.output) {
        this.output.value = this.input.value
    }

    setupItems.call(this)
    setupEvents.call(this)
}

function setupItems () {
    if (!this.window) {
        return
    }

    let items = Array.from(this.list.children)
    items.forEach(item => {
        const value = item.dataset.value

        if (this.isColor) {
            item.title = value
            item.style.backgroundColor = value
        } else if (this.svgPath) {
            item.innerHTML = `<svg><use xlink:href="${this.svgPath +
                value}"></use></svg>`
        }
    })
}

function setupEvents () {
    merge(
        fromEvent(this.input, 'keyup'),
        fromEvent(this.input, 'change')
    ).subscribe(() => {
        this.btn.style.backgroundColor = this.input.value
    })

    if (this.window) {
        fromEvent(this.list, 'click')
            .pipe(
                filter(evt => evt.target.dataset.value),
                map(evt => evt.target.dataset.value)
            )
            .subscribe(value => {
                setValue.call(this, value)
                closeWindow.call(this)
            })

        merge(
            fromEvent(this.btn, 'click'),
            fromEvent(this.el, 'click').pipe(
                filter(evt =>
                    evt.target.classList.contains('js-item-picker-drop-btn')
                )
            )
        ).subscribe(toggleOpenWindow.bind(this))
        merge(
            fromEvent(this.input, 'click'),
            fromEvent(this.input, 'focus')
        ).subscribe(openWindow.bind(this))
        if (this.output) {
            fromEvent(this.output, 'click').subscribe(openWindow.bind(this))
        }
        fromEvent(this.window, 'click')
            .pipe(
                filter(evt =>
                    evt.target.classList.contains('js-item-picker-close')
                )
            )
            .subscribe(closeWindow.bind(this))
    }
}

function setValue (value) {
    this.input.value = value

    if (this.isColor) {
        this.btn.style.backgroundColor = value
    } else if (this.svgPath) {
        this.btn.innerHTML = `<svg><use xlink:href="${this.svgPath +
            value}"></use></svg>`
    }

    if (this.output) {
        this.output.value = this.input.value
    }
}

function toggleOpenWindow () {
    if (!this.window) {
        return
    }

    if (this.el.classList.contains('is-open')) {
        closeWindow.call(this)
    } else {
        openWindow.call(this)
    }
}

function closeWindow () {
    if (!this.window) {
        return
    }
    this.el.classList.remove('is-open')
}

function openWindow () {
    this.el.classList.add('is-open')

    itemPickers.filter(el => el !== this).forEach(el => {
        closeWindow.call(el)
    })
}
