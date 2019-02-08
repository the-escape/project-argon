<template>
    <div class="c-media-library">
        <action-bar />

        <div class="c-media-library__body">
            <tree />

            <search-results v-if="search.hasKeywords()" />
            <directory-view v-else />
        </div>

        <edit v-if="editItem.isSet()" />
    </div>
</template>

<script>
import { mapState } from 'vuex'
import {
    Tree,
    ActionBar,
    SearchResults,
    DirectoryView,
    Edit
} from './index'

export default {
    computed: {
        ...mapState(['search', 'editItem']),
    },
    components: {
        Tree,
        ActionBar,
        SearchResults,
        DirectoryView,
        Edit
    }
}
</script>
