import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import draggable from '../../vendor/vuedraggable'
import { getStore } from './store'

Vue.config.productionTip = false
Vue.component('draggable', draggable)
Vue.use(Vuex)

export function Fields () {
    const fieldEls = document.querySelectorAll('.js-fields')
    const fields = Array.from(fieldEls)

    return fields.map(el => {
        const name = el.dataset.name

        const store = getStore()

        let fieldGroups = window.fieldGroups[name]
        fieldGroups = fieldGroups.map(field => {
            field.values = field.values.map((val, id) => ({
                val,
                id
            }))
            return field
        })

        store.commit('setFields', fieldGroups)

        return new Vue({
            store,
            render: h => h(App)
        }).$mount(el)
    })
}
