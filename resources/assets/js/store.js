import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        blocks: []
    },
    getters: {
        allBlocks(state) {
            return state.blocks
        }
    },
    mutations: {
        addBlock(state, block) {
            state.blocks.push(block)
        }
    }
});
