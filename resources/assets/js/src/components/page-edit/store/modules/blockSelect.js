export const blockSelect = {
    namespaced: true,
    state: {
        nonSortableRenderingGroups: [],
        renderingGroups: [],
        blockList: [],
        hasRenderable: false,
        renderSearch: '',
        blockSearch: ''
    },
    mutations: {
        addGroups (state, { groups }) {
            state.nonSortableRenderingGroups = groups.filter(
                el =>
                    (!el.isRenderable || el.isRendering) &&
                    !el.isSortable &&
                    !el.isTab
            )

            state.renderingGroups = groups.filter(
                el =>
                    (!el.isRenderable || el.isRendering) &&
                    el.isSortable &&
                    !el.isTab
            )

            state.blockList = groups.filter(
                el => el.isRenderable && !el.isRendering
            )

            state.hasRenderable = !!groups.find(group => group.isRenderable)
        },
        setRenderSearch (state, { searchString }) {
            state.renderSearch = searchString
        },
        setBlockSearch (state, { searchString }) {
            state.blockSearch = searchString
        },
        updateRenderingBlockList (state, { blocks }) {
            state.renderingGroups = blocks.map(block => {
                block.isRendering = true
                return block
            })
        },
        updateBlockList (state, { blocks }) {
            state.blockList = blocks.map(block => {
                block.isRendering = false
                return block
            })
        },
        addBlockToRendering (state, { id }) {
            const block = state.blockList.find(block => block.id === id)
            if (!block) {
                return
            }
            state.blockList = state.blockList.filter(block => block.id !== id)
            block.isRendering = true
            state.renderingGroups.push(block)
        },
        removeBlockFromRendering (state, { id }) {
            const block = state.renderingGroups.find(block => block.id === id)
            if (!block) {
                return
            }
            state.renderingGroups = state.renderingGroups.filter(
                block => block.id !== id
            )
            block.isRendering = false
            state.blockList.push(block)
        }
    },
    getters: {
        filteredRenderList: state =>
            state.renderingGroups.filter(block =>
                block.name.toLowerCase().includes(state.renderSearch)
            ),
        filteredBlockList: state =>
            state.blockList.filter(block =>
                block.name.toLowerCase().includes(state.blockSearch)
            ),
        filteredRenderNonSortList: state =>
            state.nonSortableRenderingGroups.filter(block => {
                return block.name.toLowerCase().includes(state.renderSearch)
            }),
        renderOrder: state =>
            state.renderingGroups.map(block => block.id).join(',')
    }
}
