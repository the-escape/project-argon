<template>
    <div class="c-media-library__directory-view" v-bar>
        <div class="ml__heading">
            Found {{ search.getResultsCount() }} results for `{{ search.keywords }}`
        </div>
        <div class="ml__body">
            <div class="search-results" v-if="search.hasResults()">
                <file-list v-bind:items="search.getResults()" v-bind:folders="{}"/>
            </div>
            <div class="search-results" v-else>
                <p>No results found.</p>
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
