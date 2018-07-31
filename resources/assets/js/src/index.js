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
    createMultiple
} from './ui'
import { initialiseFormElements } from './form'
import { trees } from './ui/tree'

function init () {
    polyfill()
    Jump.init(650, 150)
    Accordion()
    Video()
    map()
    setupModals()
    initialiseFormElements()
    ScrollAnim() // add c-grid-anim | c-line-anim | c-scroll-anim--fade-up with js-scroll-anim to animate a component on scroll
    const basicConfirm = document.querySelector('.js-confirm')
    confirm(basicConfirm, () => console.log('dup'), () => console.log('delete'))
    trees()
    combos()
    tables()

    const multi = document.querySelector('.js-multi')
    createMultiple(multi, ['2017/04/10', '2017/04/25', '2018/06/10'])
}

if (document.readyState !== 'loading') {
    init()
} else {
    document.addEventListener('DOMContentLoaded', init)
}
