import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        entityGroups: [],
        entityRevisionGroups: []
    },
    getters: {
        allEntityGroups(state) {
            return state.entityGroups
        },
        allEntityRevisionGroups(state) {
            return state.entityRevisionGroups
        }
    },
    mutations: {
        addEntityGroup(state, entityGroup) {
            state.entityGroups.push(entityGroup)
        },
        removeEntityGroup(state, payload) {
            let entityGroup = state.entityGroups.find((p) => {
                return p.id === payload.id
            });

            state.entityGroups.splice(state.entityGroups.indexOf(entityGroup), 1)
        },
        addEntityRevisionGroup(state, entityRevisionGroup) {
            state.entityRevisionGroups.push(entityRevisionGroup)
        },
        removeEntityRevisionGroup(state, payload) {
            let entityRevisionGroup = state.entityRevisionGroups.find((p) => {
                return p.id === payload.id
            });

            state.entityRevisionGroups.splice(state.entityRevisionGroups.indexOf(entityRevisionGroup), 1)
        }
    }
});
