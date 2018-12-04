import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

const TabsObj = {
    el: null,
    navContainer: null,
    nav: null,
    panels: null,
    currentTab: null
}

export function Tabs () {
    const tabEls = document.querySelectorAll('.js-tabs')
    let tabs = Array.from(tabEls)
    tabs = tabs.map(el => createTabs(el))
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
            map(evt => evt.target.dataset.tab)
        )
        .subscribe(changeTab.bind(this))
}

function changeTab (tabName) {
    if (!this.panels[tabName]) {
        return
    }

    this.panels[this.currentTab].classList.remove('active')
    this.nav[this.currentTab].classList.remove('active')
    this.panels[tabName].classList.add('active')
    this.nav[tabName].classList.add('active')
    this.currentTab = tabName
}
