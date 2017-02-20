import Vue from 'vue'

export function getFolders (cb) {
    Vue.http.get('/admin/media/folders').then(response => {
        cb(response.data.data)
    })
}

export function storeFolder (parentId, name, done, error) {
    Vue.http.post('/admin/media/folders/store', { parent_id: parentId, name: name }).then(response => {
        done(response.data.data)
    }, response => {
        error(response.data.data)
    })
}

export function getItems (folder, cb) {
    Vue.http.get('/admin/media/' + folder.id + '/items').then(response => {
        cb(response.data.data)
    })
}

export function searchItems (searchQuery, cb) {
    Vue.http.post('/admin/media/search', { searchQuery: searchQuery }).then(response => {
        cb(response.data.data)
    })
}
