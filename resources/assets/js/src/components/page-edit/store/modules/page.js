export const page = {
    namespaced: true,
    state: {
        pageID: -1,
        pageTitle: '',
        pagePath: '',
        pageLink: '',
        fieldIds: [],
        isEditingPublishedRevision: false,
        currentRevisionID: -1,
        publishedRevisionID: -1,
        revisions: []
    },
    mutations: {
        setPage (
            state,
            { id, title, path, link, isEditingPublishedRevision, fieldIds }
        ) {
            state.pageID = id
            state.pageTitle = title
            state.pagePath = path
            state.pageLink = link
            state.isEditingPublishedRevision = isEditingPublishedRevision
            state.fieldIds = fieldIds
        },
        setRevisions (
            state,
            { currentRevisionID, publishedRevisionID, revisions }
        ) {
            state.currentRevisionID = currentRevisionID
            state.publishedRevisionID = publishedRevisionID
            state.revisions = revisions
        }
    },
    actions: {
        setPageRevisions ({ commit }, pageID) {
            const revisions = window.revisions[pageID]
            if (!revisions) {
                console.warn('No revisions found for pageID:' + pageID)
                return
            }

            commit('setRevisions', revisions)
        },
        setPage ({ commit }, pageID) {
            const pageObj = window.page[pageID]
            pageObj.id = pageID
            commit('setPage', pageObj)
        }
    }
}
