import Vue from 'vue'

const _folders = [
    {"id": 1},
    {"id": 2}
]

export default {
    getFolders (cb) {
        Vue.http.get('/admin/media/folders').then(response => {
            cb(response.data.data)
        })
    }
}
