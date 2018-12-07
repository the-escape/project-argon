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
    CreateCropper
} from './ui'
import { initialiseFormElements, registerFormSaveEvents } from './form'
import resetForm from './form/reset-form'
import { trees } from './ui/tree'
import { Fields, PageEdit, Cropper, setCropperImage } from './components'

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
    trees()
    tables()
    initialiseFormElements()
    registerFormSaveEvents()
    // resetForm()
    Fields()
    Tabs()
    PageEdit()
    // CreateCropper()
    cropperTest()
}

function cropperTest () {
    Cropper()

    setCropperImage({ path: 'https://picsum.photos/1920/1080/?random' }).then(
        console.log
    )

    // const btn = document.querySelector('.js-spawn-cropper')
    // btn.addEventListener('click', function () {
    //     setCropperImage({ path: 'https://picsum.photos/800/600/?random' }).then(
    //         console.log
    //     )
    // })
}

if (document.readyState !== 'loading') {
    init()
} else {
    document.addEventListener('DOMContentLoaded', init)
}
