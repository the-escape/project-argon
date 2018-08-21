import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

let sidebar

export default function init () {
    sidebar = document.querySelector('.js-sidebar')
    if (!sidebar) {
        return
    }

    fromEvent(sidebar, 'mouseenter').subscribe(openNav)
    fromEvent(sidebar, 'mouseleave').subscribe(closeNav)
}

function openNav() {
    sidebar.classList.add('active')
}

function closeNav() {
    sidebar.classList.remove('active')
}