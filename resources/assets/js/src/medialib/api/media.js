import Vue from 'vue'

export function getFolders (folderId, cb) {
    Vue.http.get('/admin/media/api/folders/'+encodeURIComponent(folderId)).then(response => {
        cb(response.body)
    })
}

export function getFoldersData (cb) {
    Vue.http.get('/admin/media/api/folders').then(response => {
        cb(response.body)

    })
}

export function search (keywords, cb) {
    Vue.http.get('/admin/media/api/search/'+encodeURIComponent(keywords)).then(response => {
        cb(response.body)
    })
}

// export function storeFolder (parentId, name, done, error) {
//     Vue.http.post('/admin/media/folders/store', { parent_id: parentId, name: name }).then(response => {
//         done(response.data.data)
//     }, response => {
//         error(response.data.data)
//     })
// }
//
// export function getItems (folder, cb) {
//     Vue.http.get('/admin/media/' + folder.id + '/items').then(response => {
//         cb(response.data.data)
//     })
// }
//
// export function searchItems (searchQuery, cb) {
//     Vue.http.post('/admin/media/search', { searchQuery: searchQuery }).then(response => {
//         cb(response.data.data)
//     })
// }
