import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'

const toggleValueClass = '.js-toggle-value'
const toggleInputClass = 'js-toggle-input'

export default function init () {
    fromEvent(document, 'change')
        .pipe(
            filter(evt => {
                return evt.target.classList.contains(toggleInputClass)
            })
        )
        .subscribe(evt => {
            const isChecked = evt.target.checked
            const valueInput = evt.target.parentNode.parentNode.querySelector(
                toggleValueClass
            )
            valueInput.value = isChecked ? 1 : 0
        })
}
