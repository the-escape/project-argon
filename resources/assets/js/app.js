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

Vue.filter('length', (value) => {
    let length = 28;
    if (value.length < length) {
        return value;
    }

    length = length - 3;

    return value.substring(0, length) + '...';
});
