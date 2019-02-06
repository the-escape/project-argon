<template>
    <div class="c-media-library">
        <action-bar />

        <div class="c-media-library__body">
            <directory-tree />

            <search-results v-if="search.hasKeywords()" />
            <directory-view v-else />
        </div>

        <modal />
    </div>
</template>

<script>
import { mapState } from 'vuex'
import {
    DirectoryTree,
    ActionBar,
    SearchResults,
    DirectoryView,
    Modal
} from './components'

export default {
    created () {
        this.$store.dispatch('loadLibrary');
    },
    computed: {
        ...mapState(['search'])
    },
    components: {
        DirectoryTree,
        ActionBar,
        SearchResults,
        DirectoryView,
        Modal
    }
}
</script>
