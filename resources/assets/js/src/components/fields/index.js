import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import draggable from 'vuedraggable'
import types from './types/types.vue'
import { getStore, processFields } from './store'
import { addTabInit } from '../../ui/tabs'

Vue.config.productionTip = false
Vue.component('draggable', draggable)
Vue.component('types', types)
Vue.use(Vuex)

export function Fields () {
    const fieldEls = document.querySelectorAll('.js-fields')
    const fields = Array.from(fieldEls)

    return fields.map(el => {
        const name = el.dataset.name

        const store = getStore()

        let { fields, header, actions = true } = window.fieldGroups[name]
        fields = processFields(fields)

        store.commit('setFields', { fields: fields })
        store.commit('setHeader', { header })
        store.commit('setShowActions', { actions })

        return new Vue({
            store,
            render: h => h(App)
        }).$mount(el)
    })
}
