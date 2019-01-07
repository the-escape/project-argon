import Vue from 'vue'
import Media from './components/Media.vue'
import VueResource from 'vue-resource'
import store from './store/store'
import VueDragDrop from 'vue-drag-drop';

Vue.use(VueResource);
Vue.use(VueDragDrop);

Vue.http.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

export function Medialib() {
    return new Vue({
        el: '#medialibapp',
        store,
        render: h => h(Media)
    });
}
