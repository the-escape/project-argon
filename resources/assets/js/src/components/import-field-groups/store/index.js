import Vue from 'vue'
import Vuex from 'vuex'
import Noty from 'noty'

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
                mappers: ''
            },
            smartImport: 0,
            isLoading: false,
            isEditorExpanded: false,
            isConfigExpanded: false,
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
            setContentMappers (state, mappers) {
                state.content.mappers = mappers
            },
            setSelectedBlock (state, block) {
                state.block = block
            },
            showLoading (state, bool) {
                state.isLoading = bool
            },
            expandEditor (state, bool) {
                state.isEditorExpanded = bool
            },
            expandConfig (state, bool) {
                state.isConfigExpanded = bool
            },
            setBlockName (state, name) {
                state.block.name = name
            },
            setBlockImage (state, image) {
                state.block.image = image
            },
            setSmartImport (state, value) {
                state.smartImport = value
            },
            createNewBlock (state) {
                state.block = {
                    id: null,
                    name: null,
                    image: null,
                    ...state.content
                }
            },
            addBlockToLibraryPanel (state) {
                state.blocks.push(state.block)
            },
            saveBlockToLibrary (state) {
                let url = '/admin/blockslibrary';

                if (!state.block.name) {
                    new Noty({
                        text: "Please provide block name",
                        type: 'error',
                        timeout: 3500
                    }).show()

                    return
                }

                if (!state.content.json) {
                    new Noty({
                        text: "Please provide json schema",
                        type: 'error',
                        timeout: 3500
                    }).show()

                    return
                }

                if (state.block.id) {
                    url += '/' + state.block.id
                }

                state.block.json = state.content.json
                state.block.blade = state.content.blade
                state.block.mappers = state.content.mappers

                Vue.http.post(url, state.block).then(response => {

                    if (response.body && response.body.success) {

                        if (response.body.block && response.body.block.id) {
                            state.block.id = response.body.block.id
                            state.blocks = [state.block, ...state.blocks]

                            new Noty({
                                text: "Block has been saved in the Blocks Library",
                                type: 'success',
                                timeout: 3500
                            }).show()
                        } else {

                            state.blocks = state.blocks.map(block => {
                                if (block.id !== state.block.id){
                                    return block
                                }
                                return {...state.block}
                            })

                            new Noty({
                                text: "Changes to the block have been saved",
                                type: 'success',
                                timeout: 3500
                            }).show()
                        }

                    } else {
                        new Noty({
                            text: "There was an error while saving the block",
                            type: 'error',
                            timeout: 3500
                        }).show()
                    }
                })
            },
            deleteBlockFromLibrary (state) {
                const url = '/admin/blockslibrary/delete/' + state.block.id

                Vue.http.post(url).then(response => {
                    if (response.body && response.body.success) {
                        state.blocks = state.blocks.filter(block => block.id !== state.block.id)
                        state.block = null
                        state.editorMode = 'json'

                        new Noty({
                            text: "Block has been removed from the Blocks Library",
                            type: 'success',
                            timeout: 3500
                        }).show()
                    }
                })
            },
            getBlockFromLibrary (state, block) {
                state.isLoading = true

                if (block.isLocal) {
                    const url = '/admin/types/' + encodeURIComponent(block.type) + '/groups/' + encodeURIComponent(block.id) + '/export'

                    Vue.http.get(url, {
                        params: {
                            json: true
                        }
                    }).then(response => {
                        state.content = {
                            json: JSON.stringify(response.body, null, 4),
                            blade: '',
                            mappers: ''
                        }
                        state.block = null
                        state.isLoading = false
                    })

                } else {
                    const url = '/admin/blockslibrary/' + encodeURIComponent(block.id)

                    Vue.http.get(url).then(response => {
                        const content = {
                            json: JSON.stringify(response.body.json, null, 4),
                            mappers: response.body.mappers,
                            blade: response.body.blade
                        }

                        state.content = content
                        state.editorMode = 'json'
                        state.block = response.body
                        state.isLoading = false
                    })
                }
            },
            importBlock (state) {
                const url = '/admin/types/' + state.type.id + '/groups/import'

                if (!state.content.json) {
                    new Noty({
                        text: "Please provide json schema",
                        type: 'error',
                        timeout: 3500
                    }).show()

                    return
                }

                Vue.http.post(url, {
                    json: state.content.json,
                    smart_import: state.smartImport
                }).then(response => {

                    if (response.body && response.body.success) {
                        new Noty({
                            text: response.body.msg || "New block has imported",
                            type: 'success',
                            timeout: 3500
                        }).show()
                    } else {
                        // todo print actual error message
                        new Noty({
                            text: response.body.error && response.body.error.json || "Block could not be imported",
                            type: 'error',
                            timeout: 3500
                        }).show()
                    }
                })
            }
        }
    })
}
