import { polyfill } from './util'
import {
    Accordion,
    Video,
    map,
    setupModals,
    ScrollAnim,
    Jump,
    tables,
    Sidebar,
    Tabs,
    Notifications,
    setupPageLeave,
    allowPageLeave,
    BasicConfirmBtns
} from './ui'
import { initialiseFormElements, registerFormSaveEvents } from './form'

import {
    Fields,
    PageEdit,
    Cropper,
    setCropperImage,
    SiteTree,
    MenuEdit,
    ImportFieldGroups,
    Medialib
} from './components'
import { Dashboard } from './dashboard'

import { fromEvent } from 'rxjs'
import { filter } from 'rxjs/operators'
// import resetForm from './form/reset-form'
import {
    Core as Uppy,
    XHRUpload,
    Dashboard as UppyDashboard,
    DragDrop
} from 'uppy'

let pageEditApp
let fieldsApps

function init () {
    polyfill()
    Jump.init(650, 150)
    ImportFieldGroups()
    Sidebar()
    Notifications()
    Accordion()
    Video()
    map()
    setupModals()
    ScrollAnim() // add c-grid-anim | c-line-anim | c-scroll-anim--fade-up with js-scroll-anim to animate a component on scroll
    tables()
    initialiseFormElements()
    registerFormSaveEvents()
    // resetForm()
    fieldsApps = Fields()
    Medialib()
    Dashboard()
    pageEditApp = PageEdit()
    Tabs(tabAction)
    MenuEdit()
    cropperTest()
    formSubmits()
    SiteTree()

    BasicConfirmBtns()

    // testUppy()
}

function tabAction (tabName) {
    if (tabName === 'page-content') {
        pageEditApp.$children[0].enableDragging()
    }

    if (tabName !== 'page-content') {
        pageEditApp.$children[0].disableDragging()
    }

    fieldsApps.forEach(app => {
        app.$children[0].toggleDraggables(tabName)
    })
}

function testUppy () {
    let metaToken = document.head.querySelector('meta[name="csrf-token"]')
    metaToken = metaToken && metaToken.content

    const uppy = Uppy()
        .use(UppyDashboard, {
            target: '.js-uppy',
            inline: true,
            width: '100%',
            height: '100%'
        })
        .use(XHRUpload, {
            endpoint: '/admin/media/api/upload',
            headers: {
                'X-CSRF-TOKEN': metaToken
            }
        })
        .use(DragDrop, {
            target: '.js-drag-drop'
        })

    uppy.on('complete', console.log)
}

function formSubmits () {
    setupPageLeave()

    fromEvent(document, 'click')
        .pipe(
            filter(evt => evt.target.dataset && evt.target.dataset.formAction)
        )
        .subscribe(evt => {
            evt.preventDefault()
            const form = evt.target.closest('form')
            form.action = evt.target.dataset.formAction
            form.submit()
        })

    const formEls = document.querySelectorAll('form.js-prevent-leave')
    const forms = Array.from(formEls)
    forms.forEach(form => {
        form.addEventListener('submit', (evt) => {
            allowPageLeave()
            const submitBtnsEls = document.querySelectorAll('[type=submit]')
            const submitBtns = Array.from(submitBtnsEls)
            submitBtns.forEach(btn => {
                btn.disabled = true
            })
            return true
        })
    })
}

function cropperTest () {
    Cropper()

    const btn = document.querySelector('.js-spawn-cropper')
    if (!btn) {
        return
    }

    btn.addEventListener('click', function () {
        setCropperImage({
            image: {
                path: 'https://picsum.photos/800/600/?random'
            },
            rotator: true,
            ratio: '16:9'
        }).then(console.log)
    })
}

if (document.readyState !== 'loading') {
    init()
} else {
    document.addEventListener('DOMContentLoaded', init)
}
