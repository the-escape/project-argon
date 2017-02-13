require('./bootstrap')

import Vue from 'vue'
import VueResource from 'vue-resource'
import store from './store'
import Media from './components/Media.vue'

Vue.use(VueResource)

new Vue({
    el: '#app',
    store,
    components: {
        Media
    }
})
