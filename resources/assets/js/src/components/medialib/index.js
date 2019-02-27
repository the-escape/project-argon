import Vue from 'vue'
import App from './App.vue'
import VueResource from 'vue-resource'
import store from './store/store'
import VueDragDrop from 'vue-drag-drop'
import Vuebar from 'vuebar'
import ConfirmBtn from '../commonComponents/confirm-btn.vue'

Vue.use(VueResource)
Vue.use(VueDragDrop)
Vue.use(Vuebar)
Vue.component('confirm-btn', ConfirmBtn)

let metaToken = document.head.querySelector('meta[name="csrf-token"]')
metaToken = metaToken && metaToken.content
Vue.http.headers.common['X-CSRF-TOKEN'] = metaToken

let hasSetupPicker = false

export function Medialib () {
    const mediaLibEl = document.querySelector('#medialibapp')
    if (!mediaLibEl) {
        return
    }

    return new Vue({
        data: {
            isPicker: false
        },
        el: mediaLibEl,
        store: store(),
        render: h => h(App)
    })
}

let mediaLibPicker

export function setupMedialibPicker () {
    if (hasSetupPicker) {
        return
    }

    const mediaLibEl = document.createElement('div')
    document.body.appendChild(mediaLibEl)

    requestAnimationFrame(() => {
        mediaLibPicker = new Vue({
            data: {
                isPicker: true
            },
            store: store(),
            render: h => h(App)
        }).$mount(mediaLibEl)
    })

    hasSetupPicker = true
}

export function PickMedia () {
    return new Promise(resolve => {
        mediaLibPicker.$emit('open')
        mediaLibPicker.$on('pick', resolve)
    })
}
