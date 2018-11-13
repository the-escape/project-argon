import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import draggable from '../../vendor/vuedraggable'
import types from './types/types.vue'
import { getStore } from './store'

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

        let fieldGroups = window.fieldGroups[name]
        fieldGroups = processFields(fieldGroups)

        store.commit('setFields', { fields: fieldGroups })

        return new Vue({
            store,
            render: h => h(App)
        }).$mount(el)
    })
}

function processFields (fields) {
    return fields.map(field => {
        if (field.options.typeKey === 'combo') {
            field = processCombo(field)
        } else {
            field.values = processValues(field.values)
        }
        return field
    })
}

function processValues (values) {
    return values.map((value, id) => ({
        value,
        id
    }))
}

function processCombo (combo) {
    combo.values = combo.values.map((comboItemValues, index) => {
        const fieldIds = Object.keys(comboItemValues)
        const values = fieldIds.reduce((acc, fieldID) => {
            acc[fieldID] = processValues(comboItemValues[fieldID])
            return acc
        }, {})
        values.id = index
        return values
    })
    return combo
}
