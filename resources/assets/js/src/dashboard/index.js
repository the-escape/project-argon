import Vue from 'vue'
import Vuebar from 'vuebar'
import { inputGroup, controller } from '../form'

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

function feedbackForm() {
    // controller('.js-feedback-form')
}