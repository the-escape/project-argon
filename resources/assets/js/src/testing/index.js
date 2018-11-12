import Vue from 'vue'
import Vuex from 'vuex'

import App from './App.vue'

Vue.config.productionTip = false
// https://github.com/SortableJS/Vue.Draggable/issues/381
const store = new Vuex.Store({
    strict: true,
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
        updateUser: function (state, payload) {
            state.fields = state.fields.map(field => {
                if (field.id !== payload.fieldID) {
                    return field
                }

                field.users = field.users.map(user => {
                    if (user.id !== payload.userID) {
                        return user
                    }
                    user = Object.assign(user, payload.user)
                    return user
                })
                return field
            })
        },
        addUser: function (state, payload) {
            state.fields = state.fields.map(field => {
                if (field.id !== payload.fieldID) {
                    return field
                }

                payload.user.id = field.users.length
                field.users.push(payload.user)
                return field
            })
        },
        updateUsers: function (state, payload) {
            state.fields = state.fields.map(field => {
                if (field.id !== payload.fieldID) {
                    return field
                }

                field.users = payload.users
                return field
            })
        }
    }
})

export default function init () {
    return new Vue({
        store,
        render: h => h(App)
    }).$mount('#test')
}
