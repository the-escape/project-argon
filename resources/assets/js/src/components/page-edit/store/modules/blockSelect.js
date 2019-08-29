export const blockSelect = {
    namespaced: true,
    state: {
        tabGroups: [],
        nonSortableRenderingGroups: [],
        renderingGroups: [],
        blockList: [],
        hasRenderable: false,
        renderSearch: "",
        blockSearch: ""
    },
    mutations: {
        addGroups(state, { groups }) {
            state.nonSortableRenderingGroups = groups.filter(
                el =>
                    (!el.isRenderable || el.isRendering) &&
                    !el.isSortable &&
                    !el.isTab
            );

            state.renderingGroups = groups.filter(
                el =>
                    (!el.isRenderable || el.isRendering) &&
                    el.isSortable &&
                    !el.isTab
            );

            state.blockList = groups.filter(
                el => el.isRenderable && !el.isRendering && !el.isTab
            );

            state.tabGroups = groups.filter(el => el.isTab);

            state.hasRenderable = !!groups.find(group => group.isRenderable);
        },
        setRenderSearch(state, { searchString }) {
            state.renderSearch = searchString;
        },
        setBlockSearch(state, { searchString }) {
            state.blockSearch = searchString;
        },
        updateRenderingBlockList(state, { blocks }) {
            state.renderingGroups = blocks.map(block => {
                block.isRendering = true;
                return block;
            });
        },
        updateBlockList(state, { blocks }) {
            state.blockList = blocks.map(block => {
                block.isRendering = false;
                return block;
            });
        },
        addBlockToRendering(state, { id }) {
            const block = state.blockList.find(block => block.id === id);
            if (!block) {
                return;
            }
            state.blockList = state.blockList.filter(block => block.id !== id);
            block.isRendering = true;
            state.renderingGroups.push(block);
        },
        removeBlockFromRendering(state, { id }) {
            const block = state.renderingGroups.find(block => block.id === id);
            if (!block) {
                return;
            }
            state.renderingGroups = state.renderingGroups.filter(
                block => block.id !== id
            );
            block.isRendering = false;
            state.blockList.push(block);
        }
    },
    getters: {
        filteredRenderList: state =>
            state.renderingGroups.filter(block =>
                block.name
                    .toLowerCase()
                    .includes(state.renderSearch.toLowerCase())
            ),
        filteredBlockList: state =>
            state.blockList.filter(block =>
                block.name
                    .toLowerCase()
                    .includes(state.blockSearch.toLowerCase())
            ),
        filteredRenderNonSortList: state =>
            state.nonSortableRenderingGroups.filter(block => {
                return block.name
                    .toLowerCase()
                    .includes(state.renderSearch.toLowerCase());
            }),
        renderOrder: state =>
            state.renderingGroups.map(block => block.id).join(",")
    },
    actions: {
        getPageGroups({ commit }, pageID) {
            const groups = window.groups[pageID];
            if (!groups) {
                console.warn("no groups found for page id:" + pageID);
                return;
            }
            commit("addGroups", { groups });
        }
    }
};
