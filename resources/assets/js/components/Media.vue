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
        <div class="media__right">
            <div class="media__header">
                <form>
                    <div class="form__group">
                        <label for="search" class="sr-only">Search library</label>
                        <input v-model="searchQuery" id="search" type="text" class="form__text icon" placeholder="Search library">
                        <span class="icon search"></span>
                    </div>
                </form>
                <div class="media__actions">
                    <h1 v-if="!searchQuery.length">{{ activeFolder.name }}</h1>
                    <h1 v-else>Search: {{ searchQuery }}</h1>
                    <a href="#" class="form__btn form__btn--small">UPLOAD MEDIA</a>
                </div>
            </div>
            <div class="media__browser">
                <div class="media__items">
                    <MediaFolder
                            v-if="!searchQuery.length"
                            v-for="folder in childFolders"
                            v-bind:folder="folder">
                    </MediaFolder>
                    <MediaItem
                            v-for="item in childItems"
                            v-bind:item="item">
                    </MediaItem>
                </div>
            </div>
        </div>
        <div v-if="isLoading" class="media__loading"></div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import MediaRow from './MediaRow.vue'
    import MediaFolder from './MediaFolder.vue'
    import MediaItem from './MediaItem.vue'

    export default {
        computed: mapGetters({
            isLoading: 'isLoading',
            activeFolder: 'activeFolder',
            allFolders: 'allFolders',
            childFolders: 'childFolders',
            childItems: 'childItems'
        }),
        data: () => {
            return {
                searchQuery: ''
            }
        },
        methods: {
            search () {
                this.$store.dispatch('searchItems', this.searchQuery)
            }
        },
        watch: {
            searchQuery: {
                handler: () => {
                    this.search()
                },
                deep: true
            }
        },
        created () {
            this.$store.dispatch('getFolders')
        },
        components: {
            MediaRow,
            MediaFolder,
            MediaItem
        }
    }
</script>
