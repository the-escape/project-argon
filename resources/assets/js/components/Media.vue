<template>
    <div class="media">
        <div class="media__tree">
            <ul>
                <MediaRow
                    v-for="folder in allFolders"
                    v-bind:folder="folder">
                </MediaRow>
            </ul>
        </div>
        <div class="media__browser">
            <div class="media__header">
                <form>
                    <input type="text" class="form__text" placeholder="Search library">
                </form>
            </div>
            <div class="row">
                <MediaFolder
                    v-for="folder in childFolders"
                    v-bind:folder="folder">
                </MediaFolder>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import MediaRow from './MediaRow.vue'
    import MediaFolder from './MediaFolder.vue'

    export default {
        computed: mapGetters({
            activeFolder: 'activeFolder',
            allFolders: 'allFolders',
            childFolders: 'childFolders'
        }),
        created () {
            this.$store.dispatch('getFolders')
        },
        components: {
            MediaRow,
            MediaFolder
        }
    }
</script>
