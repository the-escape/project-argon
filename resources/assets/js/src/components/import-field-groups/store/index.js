import Vuex from 'vuex'

export function getStore () {
    return new Vuex.Store({
        state: {
            type: null,
            types: [],
            blocks: [],
            editorMode: 'json',
            content: {
                json: '',
                blade: '',
                mapper: ''
            },
            isLoading: false,
            block: null
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
            changeEditorMode (state, mode) {
                state.editorMode = mode
            },
            setContent (state, content) {
                state.content = content
                state.editorMode = 'json'
            },
            setContentJson (state, json) {
                state.content.json = json
            },
            setContentBlade (state, blade) {
                state.content.blade = blade
            },
            setContentMapper (state, mapper) {
                state.content.mapper = mapper
            },
            setSelectedBlock (state, block) {
                state.block = block
            },
            showLoading (state, bool) {
                state.isLoading = bool
            },
            setBlockName (state, name) {
                state.block.name = name
            },
            createNewBlock (state) {
                state.block = {
                    id: null,
                    name: null,
                    image: null,
                    ...state.content
                }
            }
        }
    })
}
