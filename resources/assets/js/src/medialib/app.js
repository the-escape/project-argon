
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

import Vue from 'vue'
import Media from './components/Media.vue'
import VueResource from 'vue-resource'
import store from './store/store'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.use(VueResource);

export function Medialib() {
    return new Vue({
        el: '#medialibapp',
        store,
        render: h => h(Media)
    });
}
