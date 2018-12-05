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

export function addFolder (name, parent, cb) {
    Vue.http.post('/admin/media/api/folders/add', { name: name, parent: parent }).then(response => {
        cb(response)
    }).catch(e => {
        cb(e)
    });
}

export function editFolder (name, folderId, cb) {
    Vue.http.post('/admin/media/api/folders/edit', { name: name, folder: folderId }).then(response => {
        cb(response)
    }).catch(e => {
        cb(e)
    });
}

export function removeFolder (id, cb) {
    Vue.http.post('/admin/media/api/folders/remove', { id: id }).then(response => {
        cb(response)
    }).catch(e => {
        cb(e)
    });
}

export function uploadMedia (data, cb) {
    Vue.http.post('/admin/media/api/upload', data).then(response => {
        cb(response)
    }).catch(e => {
        cb(e)
    });
}

// min and max included
function randomIntFromRange(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
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
