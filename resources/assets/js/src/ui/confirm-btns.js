import { fromEvent, merge } from 'rxjs'
import { filter, map } from 'rxjs/operators'

const Confirm = {
    el: null,
    duplicateCB: _ => {},
    deleteCB: _ => {},
    currentQuestion: '',
    destroy: destroy,
    events: {}
}

export function confirm (el, duplicateCB, deleteCB) {
    const Obj = Object.create(Confirm)
    init.call(Obj, el, duplicateCB, deleteCB)
    return Obj
}

function init (el, duplicateCB, deleteCB) {
    if (!el) {
        return
    }

    this.el = el
    this.duplicateCB = duplicateCB
    this.deleteCB = deleteCB
    this.destroy = this.destroy.bind(this)

    setupEvents.call(this)
}

function setupEvents () {
    const click = fromEvent(this.el, 'click')

    this.events.question = click
        .pipe(
            filter(evt => evt.target.dataset.question),
            map(evt => (evt.preventDefault(), evt)),
            map(evt => evt.target.dataset.question)
        )
        .subscribe(question => {
            this.currentQuestion = question
            if (this.currentQuestion === 'duplicate') {
                this.duplicateCB()
            } else {
                this.el.classList.add('is-active')
            }
        })

    const accept = click.pipe(
        filter(evt => evt.target.classList.contains('js-confirm-accept')),
        map(evt => (evt.preventDefault(), evt)),
        map(_ => true)
    )

    const decline = click.pipe(
        filter(evt => evt.target.classList.contains('js-confirm-decline')),
        map(evt => (evt.preventDefault(), evt)),
        map(_ => false)
    )

    this.events.confirm = merge(accept, decline).subscribe(accept => {
        if (accept) {
            switchOnQuestion.call(this)
        }
        this.el.classList.remove('is-active')
    })
}

function switchOnQuestion () {
    switch (this.currentQuestion) {
    case 'duplicate':
        this.duplicateCB()
        break
    case 'delete':
        this.deleteCB()
        break
    }
}

function destroy () {
    this.events.question.unsubscribe()
    this.events.confirm.unsubscribe()
}
