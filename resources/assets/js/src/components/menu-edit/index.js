import Vue from 'vue'
import App from './App.vue'
// import { DraggableTree } from 'vue-draggable-nested-tree'
import SlVueTree from 'sl-vue-tree'

Vue.config.productionTip = false
Vue.component('tree', SlVueTree)

export function MenuEdit () {
    const menuEdit = document.querySelector('.js-menu-edit')

    if (!menuEdit) {
        return
    }

    return new Vue({
        render: h => h(App)
    }).$mount(menuEdit)
}
