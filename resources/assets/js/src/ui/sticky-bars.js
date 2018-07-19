import { fromEvent } from 'rxjs'
import { map } from 'rxjs/operators'

export default function init (selectors = [], requireAllToExist = false) {
    const stickyElements = setupStickElements(selectors)
    const scrollPositions = Object.keys(stickyElements).sort((a, b) => a - b)
    const elementCount = scrollPositions.reduce(
        (acc, key) => acc + stickyElements[key].length,
        0
    )

    if (
        !elementCount ||
        (requireAllToExist && elementCount != selectors.length)
    ) {
        return
    }

    scrollPositions.forEach(pos =>
        stickyElements[pos].forEach(obj => {
            obj.el.classList.add('toBeSticky')
        })
    )

    let lastStickiedPos = 0

    const testScroll = scroll => {
        scrollPositions.forEach(pos => {
            stickyElements[pos].forEach(obj => {
                if (+pos <= scroll) {
                    lastStickiedPos = pos
                }

                if (+pos <= scroll && !obj.el.classList.contains('sticky')) {
                    obj.el.classList.add('sticky')
                    obj.el.parentNode.style.height = obj.cbr.height + 'px'
                    obj.stickiedCB && obj.stickiedCB(obj)
                } else if (
                    +pos > scroll &&
                    obj.el.classList.contains('sticky')
                ) {
                    obj.el.classList.remove('sticky')
                    obj.el.parentNode.style.height = ''
                    obj.unstickiedCB && obj.unstickiedCB(obj)
                }
            })
        })

        scrollPositions.forEach(pos => {
            stickyElements[pos].forEach(obj => {
                if (
                    +pos < lastStickiedPos &&
                    !obj.el.classList.contains('old-sticky')
                ) {
                    obj.el.classList.add('old-sticky')
                } else if (
                    +pos >= lastStickiedPos &&
                    obj.el.classList.contains('old-sticky')
                ) {
                    obj.el.classList.remove('old-sticky')
                }
            })
        })
    }

    fromEvent(window, 'scroll')
        .pipe(map(() => currentScroll()))
        .subscribe(testScroll)

    testScroll(currentScroll())
}

function currentScroll () {
    return window.scrollY || window.pageYOffset
}

function setupStickElements (selectors = []) {
    return selectors.reduce((acc, selector) => {
        if (typeof selector === 'string') {
            selector = [selector, null, null]
        }

        const element = document.querySelector(selector[0])
        if (!element) {
            return acc
        }

        const cbr = element.getBoundingClientRect()
        const elementPos = cbr.top + currentScroll()

        if (typeof acc[elementPos] === 'undefined') {
            acc[elementPos] = []
        }

        acc[elementPos].push({
            el: element,
            cbr,
            stickiedCB: selector[1],
            unstickiedCB: selector[2]
        })
        return acc
    }, {})
}
