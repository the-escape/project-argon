import Vue from 'vue'

export function pickImage (imageId, cb) {
    Vue.http
        .get('/admin/media/items/' + encodeURIComponent(imageId))
        .then(response => {
            const {
                id,
                url,
                filename,
                meta: { width, height }
            } = response.body
            const mediaObj = {
                id,
                url,
                filename,
                width,
                height
            }
            cb(mediaObj)
        })
}

export function getFolders (folderId, cb) {
    Vue.http
        .get('/admin/media/api/folders/' + encodeURIComponent(folderId))
        .then(response => {
            cb(response.body)
        })
}

export function getFoldersData (cb) {
    Vue.http.get('/admin/media/api/folders').then(response => {
        cb(response.body)
    })
}

export function search (keywords, cb) {
    Vue.http
        .get('/admin/media/api/search/' + encodeURIComponent(keywords))
        .then(response => {
            cb(response.body)
        })
}

export function addFolder (name, parent, cb) {
    Vue.http
        .post('/admin/media/api/folders/add', { name: name, parent: parent })
        .then(response => {
            cb(response)
        })
        .catch(e => {
            cb(e)
        })
}

export function editFolder (name, folderId, cb) {
    Vue.http
        .post('/admin/media/api/folders/edit', { name: name, folder: folderId })
        .then(response => {
            cb(response)
        })
        .catch(e => {
            cb(e)
        })
}

export function removeFolder (id, cb) {
    Vue.http
        .post('/admin/media/api/folders/remove', { id: id })
        .then(response => {
            cb(response)
        })
        .catch(e => {
            cb(e)
        })
}

export function removeItem (id, cb) {
    Vue.http
        .post('/admin/media/api/items/remove', { id: id })
        .then(response => {
            cb(response)
        })
        .catch(e => {
            cb(e)
        })
}

export function move (data, cb) {
    Vue.http
        .post('/admin/media/api/move', data)
        .then(response => {
            cb(response)
        })
        .catch(e => {
            cb(e)
        })
}

export function recentUploads (cb) {
    Vue.http
        .get('/admin/media/api/recent')
        .then(response => {
            cb(response)
        })
        .catch(e => {
            cb(e)
        })
}

export function remove (data, cb) {
    Vue.http
        .post('/admin/media/api/delete', data)
        .then(response => {
            cb(response.body)
        })
        .catch(e => {
            cb(e)
        })
}

export function update ({ id, file }) {
    const formData = new FormData()
    formData.append('file', file)
    formData.append('mediaID', id)

    return Vue.http
        .post('/admin/media/api/update', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => response.body)
}
