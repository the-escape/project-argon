import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

let accordions

const classes = {
    active: 'active',
    container: 'o-accordion__container'
}

export default function init () {
    accordions = document.querySelectorAll('.js-accordion')
    if (!accordions.length) {
        return
    }

    accordions = Array.prototype.slice.call(accordions)
    accordions.forEach(el => {
        setAccordionContentHeight(el)
        if (!el.classList.contains(classes.active)) {
            return
        }
        const container = el.querySelector('.' + classes.container)
        const height = el.dataset.accordionHeight
        container.style.height = Math.ceil(height) + 'px'
    })

    addEventListeners()
}

function setAccordionContentHeight (accordionElement) {
    let cleanUp = false

    if (!accordionElement.classList.contains('active')) {
        accordionElement.classList.add('active')
        cleanUp = true
    }

    let container = accordionElement.querySelector('.' + classes.container)
    let { height } = container.getBoundingClientRect()

    accordionElement.dataset.accordionHeight = height

    if (cleanUp) {
        accordionElement.classList.remove('active')
    }
}

function addEventListeners () {
    fromEvent(document, 'click')
        .pipe(
            filter(
                e =>
                    e.target.classList.contains('.js-accordion') ||
                    e.target.closest('.js-accordion')
            ),
            map(e => e.target.closest('.js-accordion'))
        )
        .subscribe(handleClick)
}

function handleClick (accordion) {
    const container = accordion.querySelector('.' + classes.container)

    if (accordion.classList.contains(classes.active)) {
        accordion.classList.remove(classes.active)
        container.style.height = 0
        return
    }

    const height = accordion.dataset.accordionHeight
    container.style.height = Math.ceil(height) + 'px'
    accordion.classList.add(classes.active)
}
