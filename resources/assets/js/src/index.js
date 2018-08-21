import { polyfill } from './util'
import {
    Accordion,
    Video,
    map,
    setupModals,
    ScrollAnim,
    confirm,
    combos,
    Jump,
    tables,
    createTemplateForms,
    Sidebar
} from './ui'
import { initialiseFormElements, registerFormSaveEvents } from './form'
import { trees } from './ui/tree'

function init () {
    polyfill()
    Jump.init(650, 150)
    Sidebar()
    Accordion()
    Video()
    map()
    setupModals()
    initialiseFormElements()
    ScrollAnim() // add c-grid-anim | c-line-anim | c-scroll-anim--fade-up with js-scroll-anim to animate a component on scroll
    const basicConfirm = document.querySelector('.js-confirm')
    confirm(basicConfirm, () => console.log('dup'), () => console.log('delete'))
    trees()
    // combos()
    tables()
    createTemplateForms()
    // initialiseFormElements()
    registerFormSaveEvents()
}

if (document.readyState !== 'loading') {
    init()
} else {
    document.addEventListener('DOMContentLoaded', init)
}
