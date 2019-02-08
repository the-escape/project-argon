<template>
    <div class="c-media-library__directory-view">
        <div class="c-media-library__breadcrumbs" v-if="active.isSet()">
            <button v-for="folder of active.breadcrumbs()" :key="folder.id" @click="folderSelected(folder)">
                {{ folder.name }}
            </button>
        </div>

        <div class="c-media-library__grid-wrap">
            <file-list v-bind:items="active.items" v-bind:folders="active.children" v-if="active.hasContent()" />
            <h3 v-else>No content</h3>
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
        ...mapState(['active', 'back'])
    },
    methods: {
        folderSelected(folder) {
            this.$store.dispatch('folderSelected', {folder})
        }
    }
}
</script>
