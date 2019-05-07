import { fromEvent } from 'rxjs'
import { filter, map } from 'rxjs/operators'

const TabsObj = {
    el: null,
    navContainer: null,
    navTemplate: null,
    nav: null,
    panels: null,
    currentTab: null
}

let tabs
let tabInitMap = {}

export function Tabs () {
    const tabEl = document.querySelector('.js-tabs')
    tabs = createTabs(tabEl)

    const tabUrlParamRegex = /[?&]tab(=([^&#]*)|&|#|$)/
    const titleUrlParamRegex = /[?&]title(=([^&#]*)|&|#|$)/
    let tab = tabUrlParamRegex.exec(window.location.search)
    let title = titleUrlParamRegex.exec(window.location.search)
    if (tab && tab[2]) {
        changeTab(tab[2], title[2])
    }

    window.addEventListener('popstate', evt => {
        if (evt.state && evt.state.tab) {
            changeTab(evt.state.tab, evt.state.title, false)
        }
    })

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

export function addTabInit (tabName, cb) {
    tabInitMap[tabName] = cb
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
    this.navTemplate = setupTemplate(this.nav[0].parentNode.innerHTML)
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

function setupTemplate (html) {
    return (tab, title) => {
        const div = document.createElement('li')
        div.innerHTML = html
        div.firstElementChild.classList.add('to-remove')
        div.firstElementChild.classList.add('active')
        div.firstElementChild.dataset.tab = tab
        div.querySelector('span').innerText = title
        return div
    }
}

export function changeTab (tabName, title = '', pushstate = true) {
    if (!tabs.panels || !tabs.panels[tabName] || tabName === tabs.currentTab) {
        return
    }

    tabs.panels[tabs.currentTab].classList.remove('active')
    if (tabs.nav[tabs.currentTab]) {
        if (tabs.nav[tabs.currentTab].classList.contains('to-remove')) {
            tabs.nav[tabs.currentTab].parentNode.remove()
            tabs.nav[tabs.currentTab] = null
        } else {
            tabs.nav[tabs.currentTab].classList.remove('active')
        }
    }

    tabs.panels[tabName].classList.add('active')
    tabInitMap[tabName] && tabInitMap[tabName]()

    if (!tabs.nav[tabName]) {
        const newTabNav = tabs.navTemplate(tabName, title)
        const insertBeforeEl = tabs.navContainer.firstElementChild.children[1]
        tabs.navContainer.firstElementChild.insertBefore(
            newTabNav,
            insertBeforeEl
        )
        tabs.nav[tabName] = newTabNav.firstElementChild
    } else {
        tabs.nav[tabName].classList.add('active')
    }

    if (!title) {
        title = tabs.nav[tabName].querySelector('span').innerText
    }

    tabs.currentTab = tabName

    if (pushstate) {
        history.pushState(
            { tab: tabName, title },
            tabName,
            `?tab=${tabName}&title=${title}`
        )
    }
}
