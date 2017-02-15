import Vue from 'vue'

export default {
    getFolders (cb) {
        Vue.http.get('/admin/media/folders').then(response => {
            cb(response.data.data)
        })
    },
    getItems (folder, cb) {
        Vue.http.get('/admin/media/' + folder.id + '/items').then(response => {
            cb(response.data.data)
        })
    }
}
