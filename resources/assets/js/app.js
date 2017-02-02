import Vue from 'vue'
import store from './store'
import Sortable from 'sortablejs'
import PageBuilder from './components/page-builder/PageBuilder.vue'

window.$ = require('jquery');

Vue.directive('sortable', {
    inserted: function (el, binding) {
        new Sortable(el, binding.value || {})
    }
});

const app = new Vue({
    el: '#app',
    store,
    components: {
        PageBuilder
    }
});

export { app, store }

let sidebar = $('.sidebar');

sidebar.on('mouseenter', function () {
    let self = $(this);
    self.parent().addClass('active');
    self.prev('.sidebar__overlay').stop().fadeIn(200);
});

sidebar.on('mouseleave', function () {
    let self = $(this);
    self.parent().removeClass('active');
    self.prev('.sidebar__overlay').stop().fadeOut(200);
});
