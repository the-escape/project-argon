import dragula from 'dragula'

const DragSelect = {
    el: null,
    input: null,
    inactiveColumn: null,
    activeColumn: null,
    drag: null,
    values: null
}

export function createDragSelects (context = document) {
    const dragEls = context.querySelectorAll('.js-drag')
    let dragSelects = Array.from(dragEls)
    dragSelects = dragSelects.map(el => createDragSelect(el))
    return dragSelects
}

export function createDragSelect (el) {
    const Obj = Object.create(DragSelect)
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

    this.input = this.el.querySelector('.js-drag-input')
    this.inactiveColumn = this.el.querySelector('.js-drag-inactive')
    this.activeColumn = this.el.querySelector('.js-drag-active')
    this.values = []

    setupIntialValues.call(this)
    setupDrag.call(this)
    setupEvents.call(this)
}

function setupDrag () {
    this.drag = dragula([this.inactiveColumn, this.activeColumn], {
        revertOnSpill: true,
        removeOnSpill: false,
        moves: el => el.dataset.value
    })
}

function setupEvents () {
    this.drag.on('drop', (el, target, source, sibling) => {
        if (target === this.activeColumn && source !== this.activeColumn) {
            const siblingValue = (sibling && sibling.dataset.value) || false
            addItem.call(this, el.dataset.value, siblingValue)
        }

        if (source === this.activeColumn) {
            const siblingValue = (sibling && sibling.dataset.value) || false
            removeItem.call(this, el.dataset.value)
            addItem.call(this, el.dataset.value, siblingValue)
        }

        if (target === this.inactiveColumn) {
            removeItem.call(this, el.dataset.value)
        }

        updateValues.call(this)
    })
}

function addItem (value, siblingValue) {
    if (siblingValue) {
        const index = this.values.indexOf(siblingValue)

        this.values.splice(index, 0, value)
    } else {
        this.values.push(value)
    }
}

function removeItem (value) {
    this.values = this.values.filter(el => el !== value)
}

function updateValues () {
    this.input.value = JSON.stringify(this.values)
}

function setupIntialValues () {
    if (!this.input.value) {
        return
    }

    Array.from(this.activeColumn.children).forEach(el => {
        this.inactiveColumn.appendChild(el)
    })

    this.values = JSON.parse(this.input.value)
    this.values.forEach(activeValue => {
        const item = this.inactiveColumn.querySelector(
            `[data-value="${activeValue}"]`
        )
        if (!item) {
            return
        }

        this.activeColumn.appendChild(item)
    })
}
