<template>
    <div class="media">
        <div class="media__tree">
            <ul>
                <MediaFolder
                        v-for="folder in folders"
                        v-bind:folder="folder">
                </MediaFolder>
            </ul>
        </div>
        <div class="media__browser">
            <h1>{{ folder.name }}</h1>
            <div class="row">
                <MediaItem></MediaItem>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import MediaFolder from './MediaFolder.vue'
    import MediaItem from './MediaItem.vue'

    export default {
        computed: mapGetters({
            folder: 'folder',
            folders: 'folders'
        }),
        created () {
            this.$store.dispatch('getAllFolders')
        },
        components: {
            MediaFolder,
            MediaItem
        }
    }
</script>
