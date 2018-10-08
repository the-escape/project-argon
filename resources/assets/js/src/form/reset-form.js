import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

export default function init () {
    fromEvent(document, 'click').pipe(
        filter(el => el.target.classList.contains('js-form-reset')),
        map(evt => (evt.preventDefault(), evt))
    ).subscribe(findAndReset)
}

function findAndReset (e) {
    let form = e.target.closest('.js-form'),
        inputs = form.querySelectorAll('[name]')

    Array.from(inputs).forEach(el => {
        if (el.classList.contains('js-select')) {
            let choices = el.choices
            choices.setValueByChoice('')
        } else if (el.hasAttribute('checked')) {
            el.checked = false
        } else {
            el.value = ''
        }
    })

    form.submit()
}