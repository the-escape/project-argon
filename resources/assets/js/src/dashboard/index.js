import Vue from 'vue'
import Vuebar from 'vuebar'
import { feedbackForm } from './feedback-form'

Vue.config.productionTip = false
Vue.use(Vuebar)

export function Dashboard() {
    activityLog()
    feedbackForm()
}

function activityLog() {
    const widget = document.querySelector('.c-activity-widget')

    if(!widget)
    {
        return
    }

    new Vue().$mount(widget)
}

