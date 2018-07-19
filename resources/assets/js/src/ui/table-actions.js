import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'
import { confirm } from './confirm-btns'

const TableActions = {
    el: null,
    id: null,
    dropdown: null,
    confirm: null,
    delete: null,
    duplicate: null,
    dropdownToggle: null,
    destroy: destroy,
    nameInput: null,
    submitEvent: null
}

export function tableAction (actions, dropdown, duplicateCB, deleteCB) {
    const Obj = Object.create(TableActions)
    init.call(Obj, actions, dropdown, duplicateCB, deleteCB)
    return Obj
}

function init (actions, dropdown, duplicateCB, deleteCB) {
    if (!actions) {
        return
    }

    this.el = actions
    const { id } = this.el.dataset
    this.id = id
    this.dropdown = dropdown

    setDropdownHeight.call(this)

    this.delete = deleteCB.bind(this)
    this.duplicate = duplicateCB.bind(this)
    this.dropdownToggle = toggleDropdown.bind(this)
    this.destroy = this.destroy.bind(this)
    this.nameInput = this.el.querySelector('[name="name"]')

    this.confirm = confirm(this.el, this.dropdownToggle, this.delete)

    fromEvent(this.el, 'click').pipe(
        filter(evt => evt.target.classList.contains())
    )
}

function toggleDropdown () {
    if (!this.dropdown) {
        return
    }

    if (this.dropdown.classList.contains('is-active')) {
        this.dropdown.classList.remove('is-active')
        this.dropdown.style.height = 0
        return
    }

    const { height } = this.dropdown.dataset
    this.dropdown.style.height = height + 'px'
    this.dropdown.classList.add('is-active')
}

function setDropdownHeight () {
    let cleanUp = false

    if (!this.dropdown.classList.contains('is-active')) {
        this.dropdown.classList.add('is-active')
        cleanUp = true
    }

    let container = this.dropdown.firstElementChild
    let { height } = container.getBoundingClientRect()

    this.dropdown.dataset.height = height

    if (cleanUp) {
        this.dropdown.classList.remove('is-active')
    }
    return height
}

function destroy () {
    this.confirm.destroy()
    delete this.confirm
}
