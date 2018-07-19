import { fromEvent } from 'rxjs'
import { map } from 'rxjs/operators'

let scrollAnimations,
    scrollAnimationKeys,
    activeClass,
    onloadAnimations,
    baseOffset

export default function init () {
    activeClass = 'scroll-active'
    baseOffset = 0.1

    setupScrollAnimation()

    fromEvent(window, 'scroll')
        .pipe(map(() => getCurrentTop() + window.innerHeight))
        .subscribe(handleScroll)

    handleScroll(getCurrentTop() + window.innerHeight)
}

function setupScrollAnimation () {
    let scrollAnimationElements = document.querySelectorAll('.js-scroll-anim')
    scrollAnimationElements = Array.from(scrollAnimationElements)

    let blockquoteAnimationElements = document.querySelectorAll(
        '.typography blockquote'
    )
    blockquoteAnimationElements = Array.from(blockquoteAnimationElements)

    onloadAnimations = []

    scrollAnimations = scrollAnimationElements
        .concat(blockquoteAnimationElements)
        .reduce((acc, el) => {
            if (el.classList.contains('onload')) {
                onloadAnimations.push(el)
                return acc
            }

            let { top } = el.getBoundingClientRect()
            let offset = el.dataset.scrollOffset || baseOffset
            top =
                Math.round(top) + getCurrentTop() + offset * window.innerHeight
            top = Math.max(top, 0)
            if (typeof acc[top] === 'undefined') {
                acc[top] = []
            }
            acc[top].push(el)
            return acc
        }, {})

    scrollAnimationKeys = Object.keys(scrollAnimations)
    scrollAnimationKeys.sort()

    if (onloadAnimations.length) {
        onloadAnimations.map(els => {
            els.map(el => {
                el.classList.add(activeClass)
            })
        })
    }
}

function handleScroll (scroll) {
    for (let i = 0; i < scrollAnimationKeys.length; i++) {
        let animScroll = scrollAnimationKeys[i]
        if (scroll >= animScroll) {
            scrollAnimations[scrollAnimationKeys[i]].map(el => {
                el.classList.add(activeClass)
            })
        }
    }
}

function getCurrentTop () {
    return window.scrollY || window.pageYOffset
}
