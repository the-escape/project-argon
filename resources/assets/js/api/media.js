import Vue from 'vue'

export default {
    getFolders (cb) {
        Vue.http.get('/admin/media/folders').then(response => {
            cb(response.data.data)
        })
    }
}
