import Vue from 'vue'
import Vuex from 'vuex'

import App from './App.vue'

Vue.config.productionTip = false
// https://ypereirareis.github.io/blog/2017/04/25/vuejs-two-way-data-binding-state-management-vuex-strict-mode/
const store = new Vuex.Store({
    state: {
        fields: [
            {
                id: 1,
                users: [
                    {
                        id: 0,
                        lastname: '',
                        firstname: ''
                    }
                ]
            },
            {
                id: 2,
                users: [
                    {
                        id: 0,
                        lastname: 'num 1',
                        firstname: 'first'
                    },
                    {
                        id: 1,
                        lastname: 'num 2',
                        firstname: 'second'
                    }
                ]
            }
        ]
    },
    mutations: {
        updateUser: function (state, user) {
            Object.assign(state.user, user)
        }
    }
})

export default function init () {
    return new Vue({
        store,
        render: h => h(App)
    }).$mount('#test')
}
