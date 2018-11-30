import { polyfill } from './util'
import {
    Accordion,
    Video,
    map,
    setupModals,
    ScrollAnim,
    Jump,
    tables,
    Sidebar
} from './ui'
import { initialiseFormElements, registerFormSaveEvents } from './form'
import resetForm from './form/reset-form'
import { trees } from './ui/tree'
import { Fields } from './fields'

function init () {
    polyfill()
    Jump.init(650, 150)
    Sidebar()
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
}

if (document.readyState !== 'loading') {
    init()
} else {
    document.addEventListener('DOMContentLoaded', init)
}
