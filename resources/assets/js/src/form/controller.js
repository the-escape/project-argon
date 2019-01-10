import { Subject } from 'rxjs'
import { post } from '../util'
import { modalController } from '../ui'
import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

const Controller = {
    el: null,
    inputs: [],
    errorMessageEl: null,

    inputKeys: [],
    isFormDirty: false,
    action: '',

    onErrorEvent: null,
    onSucccessEvent: null,

    onError: null,
    onSucccess: null,

    init,
    resetFormErrors
}

export default function createController (selector, onSucccess, onError) {
    const Obj = Object.create(Controller)
    Obj.init(selector, onSucccess, onError)
    return Obj
}

function init (selector, onSucccess, onError) {
    if (typeof selector === 'string') {
        this.el = document.querySelector(selector)
    } else {
        this.el = selector
    }

    if (!this.el) {
        return
    }

    this.errorMessageEl = this.el.querySelector('.js-form-errros')
    this.inputs = this.el.querySelectorAll('[name]')
    this.inputs = Array.from(this.inputs)
    this.inputs = this.inputs.reduce((acc, input) => {
        if (acc[input.name]) {
            return acc
        }

        acc[input.name] = input
        return acc
    }, {})

    this.inputKeys = Object.keys(this.inputs)
    this.action = this.el.action

    this.onErrorEvent = new Subject()
    this.onSucccessEvent = new Subject()

    this.onError = onError || handleError
    this.onSucccess = onSucccess || handleReturn
    this.onError = this.onError.bind(this)
    this.onSucccess = this.onSucccess.bind(this)
    this.resetFormErrors = this.resetFormErrors.bind(this)

    this.onErrorEvent.subscribe(this.onError)
    this.onSucccessEvent.subscribe(this.onSucccess)

    this.el.addEventListener('submit', handleSubmit.bind(this))

    resetFormErrors.call(this)

    fromEvent(document, 'click').pipe(
        filter(el => el.target.classList.contains('js-form-reset')),
        map(evt => (evt.stopPropagation(), evt))
    ).subscribe(resetForm.bind(this))
}

function handleSubmit (evt) {
    evt.preventDefault()

    const formData = getFormValueObj.call(this)

    post(this.action, formData)
        .then(data => JSON.parse(data))
        .then(data => {
            this.onSucccessEvent.next({ data, formData })
        })
        .catch(err => {
            this.onErrorEvent.next(err)
        })
}

function handleReturn ({ data }) {
    if (!data) {
        return
    }

    if (data.success) {
        modalController.openModal('ThankYou')
        resetFormErrors.call(this)
        return
    }

    this.errorMessageEl.innerHTML = `<p>${data.msg}</p>`
    this.errorMessageEl.classList.add('active')

    const errorKeys = Object.keys(data.fields)
    errorKeys.forEach(key => {
        if (!~this.inputKeys.indexOf(key)) {
            return
        }

        const el = this.inputs[key]
        const formGroupEl = el.closest('.o-form__group')
        if (!formGroupEl) {
            return
        }

        const message = formGroupEl.querySelector(
            '.o-form__group-message label'
        )
        if (message) {
            message.innerHTML = data.fields[key]
        }

        formGroupEl.classList.add('error')
    })
}

function handleError () {
    handleReturn.call({
        success: false,
        msg: 'There was an issue connecting to the server, please try again.',
        fields: {}
    })
}

function resetFormErrors () {
    this.isFormDirty = false
    this.errorMessageEl.classList.remove('active')
    this.errorMessageEl.innerHTML = ''
    this.inputKeys.forEach(key => {
        const el = this.inputs[key]
        const formGroupEl = el.closest('.o-form__group')
        if (!formGroupEl) {
            return
        }

        const message = formGroupEl.querySelector(
            '.o-form__group-message label'
        )
        if (message) {
            message.innerHTML = ''
        }

        formGroupEl.classList.remove('error')
    })
}

function resetForm () {
    this.el.reset()
}

function getFormValueObj () {
    return this.inputKeys.reduce((acc, key) => {
        let value = ''
        const input = this.inputs[key]
        if (!input) {
            return
        }

        if (input.type === 'checkbox') {
            value = input.checked
        } else {
            value = input.value
        }

        acc[key] = value

        return acc
    }, {})
}
