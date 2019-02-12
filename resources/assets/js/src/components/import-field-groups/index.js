import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import { getStore } from './store'

Vue.config.productionTip = false
Vue.use(Vuex)

export function ImportFieldGroups () {
    const importFieldGroups = document.querySelector('.js-import-field-groups')

    if (!importFieldGroups) {
        return
    }

    const store = getStore()

    store.commit('setType', { type })
    store.commit('setTypes', { types })
    store.commit('setBlocks', { blocks })

    return new Vue({
        store,
        render: h => h(App)
    }).$mount(importFieldGroups)
}
