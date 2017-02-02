import Vue from 'vue'
import Vuex from 'vuex'
import { apiGet, apiPost, apiDelete } from './api'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        entityGroups: [],
        entityRevisionGroups: []
    },
    actions: {
        GET_ENTITY_REVISION: ({ commit }, { entityLocalisationId }) => {
            return apiGet('/admin/api/blocks/' + entityLocalisationId)
                .then(entityRevision => {
                    commit('ADD_ENTITY_GROUPS', { entityGroups: entityRevision.data.data.entityGroups.data })
                    commit('ADD_ENTITY_REVISION_GROUPS', {
                        entityRevisionGroups: entityRevision.data.data.entityRevisionGroups.data
                    })
                })
        },
        POST_ENTITY_GROUP_ADD: ({ commit }, { entityLocalisationId, entityGroup }) => {
            return apiPost('/admin/api/blocks/' + entityLocalisationId + '/add', entityGroup)
                .then(entityRevisionGroup => {
                    commit('REMOVE_ENTITY_GROUP', { payload: entityGroup })
                    commit('ADD_ENTITY_REVISION_GROUPS', { entityRevisionGroups: [entityRevisionGroup.data.data] })
                })
        },
        DELETE_ENTITY_REVISION_GROUP_REMOVE: ({ commit }, { entityRevisionGroup }) => {
            return apiDelete('/admin/api/blocks/' + entityRevisionGroup.id + '/remove')
                .then(entityGroup => {
                    commit('REMOVE_ENTITY_REVISION_GROUP', { payload: entityRevisionGroup })
                    commit('ADD_ENTITY_GROUPS', { entityGroups: [entityGroup.data.data] })
                })
        }
    },
    mutations: {
        ADD_ENTITY_GROUPS: (state, { entityGroups }) => {
            entityGroups.forEach(entityGroup => {
                if (entityGroup) {
                    state.entityGroups.push(entityGroup)
                }
            })
        },
        ADD_ENTITY_REVISION_GROUPS: (state, {entityRevisionGroups }) => {
            entityRevisionGroups.forEach(entityRevisionGroup => {
                if (entityRevisionGroup) {
                    state.entityRevisionGroups.push(entityRevisionGroup)
                }
            })
        },
        REMOVE_ENTITY_GROUP: (state, { payload }) => {
            let entityGroup = state.entityGroups.find(p => { return p.id === payload.id })
            state.entityGroups.splice(state.entityGroups.indexOf(entityGroup), 1)
        },
        REMOVE_ENTITY_REVISION_GROUP: (state, { payload }) => {
            let entityRevisionGroup = state.entityRevisionGroups.find(p => { return p.id === payload.id })
            state.entityRevisionGroups.splice(state.entityRevisionGroups.indexOf(entityRevisionGroup), 1)
        }
    },
    getters: {
        entityGroups(state) {
            return state.entityGroups
        },
        entityRevisionGroups(state) {
            return state.entityRevisionGroups
        }
    }
})

export default store
