<template>
    <div class="c-media-library__upload">
        <div class="c-media-library__upload-container" ref="uppy"></div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import {
    Core as Uppy,
    XHRUpload,
    Dashboard
} from 'uppy'

export default {
    data() {
        return {
            uppyInstance: null
        }
    },
    computed: {
        ...mapState(['active']),
    },
    mounted() {
        let metaToken = document.head.querySelector('meta[name="csrf-token"]')
        metaToken = metaToken && metaToken.content

        this.uppyInstance = Uppy()
            .use(Dashboard, {
                target: this.$refs.uppy,
                inline: true,
                width: '100%',
                height: '100%'
            })
            .use(XHRUpload, {
                endpoint: '/admin/media/api/upload',
                headers: {
                    'X-CSRF-TOKEN': metaToken
                },
                metaFields: ['folder']
            })

        this.uppyInstance.on('file-added', this.addFolderToFile.bind(this))
        this.uppyInstance.on('complete', this.successfulUpload.bind(this))
    },
    destroyed() {
        this.uppyInstance.off('file-added', this.addFolderToFile.bind(this))
        this.uppyInstance.off('complete', this.successfulUpload.bind(this))
    },
    methods: {
        successfulUpload(evt) {
            this.$store.dispatch('uploadResult', evt)
        },
        addFolderToFile(file) {
            this.uppyInstance.setFileMeta(file.id, {
                folder: this.active.id
            })
        }
    }
}
</script>
