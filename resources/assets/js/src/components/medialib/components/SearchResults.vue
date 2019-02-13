<template>
    <div class="c-media-library__directory-view" v-bar>
        <div>
            <div class="c-media-library__breadcrumbs">
                <p>Found {{ search.getResultsCount() }} results for `{{ search.keywords }}`</p>
            </div>
            <div class="c-media-library__grid-wrap">
                <file-list :items="search.getResults()" v-if="search.hasResults()" />
                <h3 v-else>No results found.</h3>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import FileList from "./FileList.vue"

export default {
    computed: {
        ...mapState(['search'])
    },
    components: {
        FileList
    }
}
</script>
