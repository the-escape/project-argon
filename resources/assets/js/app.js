require('./bootstrap');

import { store } from './store'
import Sortable from 'sortablejs'
import PageBuilder from './components/page-builder/PageBuilder.vue'

Vue.directive('sortable', {
    inserted: function (el, binding) {
        let sortable = new Sortable(el, binding.value || {})
    }
});

const app = new Vue({
    el: '#app',
    store,
    components: {
        'page-builder': PageBuilder
    }
});
