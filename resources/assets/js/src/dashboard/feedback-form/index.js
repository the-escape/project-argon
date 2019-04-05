import { fromEvent } from 'rxjs'
import controller from '../../form/controller'
import Noty from 'noty'

let form
let input
let msg

export function feedbackForm () {
    input = document.querySelector('.js-feedback-form-input')
    msg = document.querySelector('.js-feedback-form-message')
    const formEL = document.querySelector('.js-feedback-form')

    if (!formEL) {
        return
    }
    form = controller(formEL, onSubmit)

    fromEvent(document, 'click').subscribe(evt => {
        if (
            evt.target.classList.contains('js-feedback-form-input') &&
            document.activeElement.classList.contains('js-feedback-form-input')
        ) {
            form.el.classList.add('active')
        } else if (!evt.target.classList.contains('js-feedback-form-btn')) {
            form.el.classList.remove('active')
        }
    })
}

function onSubmit (data) {
    if (data.data.success) {
        // form.el.classList.add('submitted')
        form.el.classList.remove('active')
        form.el.reset()

        new Noty({
            layout: 'topCenter',
            text: 'Your feedback has been sent successfully.',
            type: 'success',
            timeout: 3500
        }).show()

        // setTimeout(function() {
        //     form.el.classList.remove('submitted')
        // }, 2000)
    } else {
        let error =
            'Form could not be submitted right now, please try again later.'

        if (data.data.fields.feedback.length) {
            error = data.data.fields.feedback
        } else if (data.data.msg) {
            error = data.data.msg
        }

        new Noty({
            layout: 'topCenter',
            text: error,
            type: 'error',
            timeout: 1000
        }).show()
    }
}
