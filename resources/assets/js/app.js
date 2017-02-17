require('./bootstrap');

import Vue from 'vue'
import VueResource from 'vue-resource'
import store from './store'
import Media from './components/Media.vue'

Vue.use(VueResource);

const app = new Vue({
    el: '#app',
    store,
    components: {
        Media
    }
});

Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrfToken;

Vue.filter('length', (value) => {
    let length = 25;
    if (value.length < length) {
        return value;
    }

    length = length - 3;

    return value.substring(0, length) + '...';
});
