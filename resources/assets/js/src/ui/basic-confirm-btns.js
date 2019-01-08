import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

export function BasicConfirmBtns () {
    const basicConfirmEls = document.querySelectorAll('.js-basic-confirm')
    let basicConfirms = Array.from(basicConfirmEls)
    return basicConfirms.map(el => createBasicConfirm(el))
}

const BasicConfirm = {
    el: null
}

function createBasicConfirm (el) {
    const Obj = Object.create(BasicConfirm)
    init.call(Obj, el)
    return Obj
}

function init (el) {
    if (!el) {
        return
    }

    this.el = el

    const click = fromEvent(this.el, 'click')

    click
        .pipe(
            filter(evt => evt.target.dataset.question),
            map(evt => (evt.preventDefault(), evt)),
            map(evt => evt.target.dataset.question)
        )
        .subscribe(question => {
            if (question === 'delete') {
                this.el.classList.add('is-active')
            }
        })

    click
        .pipe(
            filter(evt => evt.target.classList.contains('js-confirm-decline'))
        )
        .subscribe(_ => {
            this.el.classList.remove('is-active')
        })
}
