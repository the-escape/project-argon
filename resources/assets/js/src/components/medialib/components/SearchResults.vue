<template>
    <div class="c-media-library__directory-view">
        <div class="ml__heading">
            Found {{ search.getResultsCount() }} results for `{{ search.keywords }}`
        </div>
        <div class="ml__body">
            <div class="search-results" v-if="search.hasResults()">
                <Content v-bind:items="search.getResults()" v-bind:folders="{}"/>
            </div>
            <div class="search-results" v-else>
                <p>No results found.</p>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import Content from "./Content.vue"

export default {
    computed: {
        ...mapState(['search'])
    },
    components: {
        Content
    }
}
</script>
