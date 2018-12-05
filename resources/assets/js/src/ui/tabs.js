import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

const TabsObj = {
    el: null,
    navContainer: null,
    nav: null,
    panels: null,
    currentTab: null
}

let tabs
let tabBtns

export function Tabs () {
    const tabEl = document.querySelector('.js-tabs')
    tabs = createTabs(tabEl)

    fromEvent(document, 'click')
        .pipe(
            filter(evt => evt.target.classList.contains('js-tab-btn')),
            map(evt => {
                evt.preventDefault()
                return evt.target.dataset.tab
            })
        )
        .subscribe(changeTab)

    return tabs
}

function createTabs (el) {
    const Obj = Object.create(TabsObj)
    init.call(Obj, el)
    return Obj
}

function init (el) {
    if (!el) {
        return
    }

    this.el = el
    this.navContainer = el.querySelector('.js-tabs-nav')
    this.nav = Array.from(this.navContainer.querySelectorAll('[data-tab]'))
    this.nav = this.nav.reduce((acc, panel) => {
        acc[panel.dataset.tab] = panel
        return acc
    }, {})

    this.panels = el.querySelector('.js-tabs-list')
    this.panels = Array.from(this.panels.children)
    this.panels = this.panels.reduce((acc, panel) => {
        acc[panel.dataset.tab] = panel
        return acc
    }, {})

    const activeNav = this.navContainer.querySelector('.active')
    if (activeNav) {
        this.currentTab = activeNav.dataset.tab
    }

    fromEvent(this.navContainer, 'click')
        .pipe(
            filter(evt => evt.target.dataset.tab),
            map(evt => {
                evt.preventDefault()
                return evt.target.dataset.tab
            })
        )
        .subscribe(changeTab)
}

export function changeTab (tabName) {
    if (!tabs.panels || !tabs.panels[tabName]) {
        return
    }

    tabs.panels[tabs.currentTab].classList.remove('active')
    tabs.nav[tabs.currentTab] &&
        tabs.nav[tabs.currentTab].classList.remove('active')
    tabs.panels[tabName].classList.add('active')
    tabs.nav[tabName] && tabs.nav[tabName].classList.add('active')
    tabs.currentTab = tabName
}
