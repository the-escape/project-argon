import Vuex from 'vuex'

export function getStore () {
    return new Vuex.Store({
        state: {
            type: null,
            types: [],
            blocks: [],
            content: {
                json: '',
                blade: '',
                mapper: ''
            }
        },
        getters: {

        },
        mutations: {
            setType (state, { type }) {
                state.type = type
            },
            setTypes (state, { types }) {
                state.types = types
            },
            setBlocks (state, { blocks }) {
                state.blocks = blocks
            },
            setContent (state, content) {
                state.content = content
            }
        }
    })
}
