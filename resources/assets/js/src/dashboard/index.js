import Vue from 'vue'
import Vuebar from 'vuebar'

Vue.config.productionTip = false
Vue.use(Vuebar)

export function Dashboard() {
    activityLog()
}

function activityLog() {
    const widget = document.querySelector('.c-activity-widget')

    new Vue().$mount(widget)
}