<template>
    <div class="c-media-library">
        <action-bar />

        <div class="c-media-library__body">
            <tree />

            <recent-uploads v-if="recentUploads.show" />
            <search-results v-else-if="search.hasKeywords()" />
            <directory-view v-else />

            <edit v-if="editItem.isSet()" />
            <upload v-if="uploadIsOpen" />
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import Tree from './Tree.vue'
import ActionBar from './ActionBar.vue'
import SearchResults from './SearchResults.vue'
import DirectoryView from './DirectoryView.vue'
import Edit from './Edit.vue'
import Upload from './Upload.vue'
import RecentUploads from './RecentUploads.vue'

export default {
    computed: {
        ...mapState(['search', 'editItem', 'uploadIsOpen', 'recentUploads']),
    },
    components: {
        Tree,
        ActionBar,
        SearchResults,
        DirectoryView,
        Edit,
        Upload,
        RecentUploads
    }
}
</script>
