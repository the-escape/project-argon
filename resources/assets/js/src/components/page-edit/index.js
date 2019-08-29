import Vue from 'vue'
import App from './App.vue'
import Vuex from 'vuex'
import draggable from 'vuedraggable'
import VueRouter from 'vue-router'
import { getStore } from './store'
import types from '../fields/types/types.vue'

import PageEditComponent from './pages/PageEdit.vue'
import GroupEditComponent from './pages/GroupEdit.vue'
import RevisionsComponent from './pages/Revisions.vue'
import PageAttributesComponent from './pages/PageAttributes.vue'

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

    const pageID = pageEdit.dataset.pageId

    const store = getStore()
    store.dispatch('page/setPage', pageID)

    const routes = [
        { path: '/', component: PageEditComponent },
        { path: '/edit/page-properties', component: PageAttributesComponent },
        { path: '/edit/:id', component: GroupEditComponent },
        { path: '/revisions', component: RevisionsComponent }
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
