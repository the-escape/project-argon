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

function init () {
    polyfill()
    Jump.init(650, 150)
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
    Fields()
    Medialib()
    Dashboard()
    Tabs()
    PageEdit()
    cropperTest()
    formSubmits()
    SiteTree()
    ImportFieldGroups()
    BasicConfirmBtns()

    // testUppy()
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
        form.addEventListener('submit', () => {
            allowPageLeave()
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
