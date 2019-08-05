import Vue from 'vue'
import App from './App.vue'
import Vuex from 'vuex'
import draggable from 'vuedraggable'
import { getStore } from './store'

Vue.config.productionTip = false
Vue.component('draggable', draggable)
Vue.use(Vuex)

export function PageEdit () {
    const pageEdit = document.querySelector('.js-page-edit')

    if (!pageEdit) {
        return
    }

    const store = getStore()
    store.commit('blockSelect/addGroups', { groups: window.groups })

    return new Vue({
        store,
        render: h => h(App)
    }).$mount(pageEdit)
}
