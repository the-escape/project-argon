<template>
    <div class="c-media-library__directory-view" v-bar>
        <div>
            <div class="c-media-library__breadcrumbs">
                <p>Recent Uploads</p>
            </div>

            <div class="c-media-library__grid-wrap">
                <file-list :items="recentUploads.items" v-if="recentUploads.items.length" />
                <h3 v-else>No content</h3>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import FileList from './FileList.vue'

export default {
    components: {
        FileList
    },
    computed: {
        ...mapState(['recentUploads'])
    }
}
</script>
