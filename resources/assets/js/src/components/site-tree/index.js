import Vue from 'vue'
import App from './App.vue'
// import { DraggableTree } from 'vue-draggable-nested-tree'
import SlVueTree from 'sl-vue-tree'

Vue.config.productionTip = false
Vue.component('tree', SlVueTree)

export function SiteTree () {
    const siteTree = document.querySelector('.js-site-tree')

    if (!siteTree) {
        return
    }

    return new Vue({
        render: h => h(App)
    }).$mount(siteTree)
}
