import Vue from 'vue'
import App from './App.vue'
import draggable from 'vuedraggable'

Vue.config.productionTip = false
Vue.component('draggable', draggable)

export function PageEdit () {
    const pageEdit = document.querySelector('.js-page-edit')

    return new Vue({
        render: h => h(App)
    }).$mount(pageEdit)
}
