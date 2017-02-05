import Vue from 'vue'
import store from './store'
import Sortable from 'sortablejs'
import PageBuilder from './components/page-builder/PageBuilder.vue'

window.$ = require('jquery')
require('select2')

Vue.directive('sortable', {
    inserted: function (el, binding) {
        new Sortable(el, binding.value || {})
    }
})

const app = new Vue({
    el: '#app',
    store,
    components: {
        PageBuilder
    }
})

export { app, store }

require('./modules/sidebar')
require('./modules/sitemap')
