import Vue from 'vue'
import Vuex from 'vuex'
import App from './App.vue'
import draggable from 'vuedraggable'
import types from './types/types.vue'
import { getStore } from './store'
import { deepClone } from '../../util'
import { addTabInit } from '../../ui/tabs'

Vue.config.productionTip = false
Vue.component('draggable', draggable)
Vue.component('types', types)
Vue.use(Vuex)

export let fieldApps = {}

export function Fields () {
    const fieldEls = document.querySelectorAll('.js-fields')
    const fields = Array.from(fieldEls)

    fields.forEach(el => {
        const tabPanel = el.closest('[data-tab]')
        const tabName = tabPanel.dataset.tab

        addTabInit(tabName, () => {
            if (fieldApps[tabName]) {
                return
            }

            const name = el.dataset.name

            const store = getStore()

            let { fields, header, actions = true } = window.fieldGroups[name]
            fields = processFields(fields)

            store.commit('setFields', { fields: fields })
            store.commit('setHeader', { header })
            store.commit('setShowActions', { actions })
            const tbname = el.closest('[data-tab]').dataset.tab
            store.commit('setDataTabName', { tabName: tbname })

            fieldApps[tabName] = new Vue({
                store,
                render: h => h(App)
            }).$mount(el)
        })
    })
}

function processFields (fields) {
    return fields.map(field => {
        if (field.options.typeKey === 'combo') {
            field = processCombo(field)
        } else {
            field.values = processValues(field.values)
            field.emptyValue = createEmptyValueObj(field)

            if (!field.values.length) {
                const newValue = deepClone(field.emptyValue)
                newValue.id = 0
                field.values.push(newValue)
            }
        }
        return field
    })
}

function processValues (values) {
    if (!Array.isArray(values)) {
        values = [values]
    }

    return values.map((value, id) => ({
        value,
        id
    }))
}

function createEmptyValueObj (field) {
    let emptyValue

    switch (field.options.typeKey) {
    case 'checkbox':
        emptyValue = 0
        break
    case 'location':
        emptyValue = {
            latitude: '',
            longitude: ''
        }
        break
    case 'button':
        emptyValue = {
            label: '',
            url: '',
            class: '',
            id: '',
            target: ''
        }
        break
    default:
        emptyValue = ''
        break
    }

    return {
        value: emptyValue
    }
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

    combo.errors = combo.errors.map((comboItemErrors, index) => {
        comboItemErrors.id = index
        return comboItemErrors
    })

    combo.fields = combo.fields.map(field => {
        field.emptyValue = createEmptyValueObj(field)
        return field
    })

    combo.emptyValue = combo.fields.reduce((acc, field) => {
        acc[field.id] = [field.emptyValue]
        return acc
    }, {})

    return combo
}
