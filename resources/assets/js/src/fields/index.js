import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false

export function Fields () {
    const fieldEls = document.querySelectorAll('.js-fields')
    const fields = Array.from(fieldEls)

    return fields.map(el => {
        const name = el.dataset.name

        return new Vue({
            fieldGroupName: name,
            render: h => h(App)
        }).$mount(el)
    })
}
