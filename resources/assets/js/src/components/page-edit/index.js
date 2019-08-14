import Vue from 'vue'
import App from './App.vue'
import Vuex from 'vuex'
import draggable from 'vuedraggable'
import VueRouter from 'vue-router'
import { getStore } from './store'
import types from '../fields/types/types.vue'

import PageEditComponent from './pages/PageEdit.vue'
import GroupEditComponent from './pages/GroupEdit.vue'

// Vue.config.productionTip = false
Vue.use(VueRouter)
Vue.component('draggable', draggable)
Vue.component('types', types)
Vue.use(Vuex)

export function PageEdit () {
    const pageEdit = document.querySelector('.js-page-edit')

    if (!pageEdit) {
        return
    }

    const store = getStore()
    store.commit('blockSelect/addGroups', { groups: window.groups })

    const routes = [
        { path: '/', component: PageEditComponent },
        { path: '/edit/:id', component: GroupEditComponent }
    ]

    const router = new VueRouter({
        routes
    })

    return new Vue({
        store,
        router,
        render: h => h(App)
    }).$mount(pageEdit)
}
