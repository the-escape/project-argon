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
                            v-if="!searchQuery.length && !isLoading"
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
        <MediaModal></MediaModal>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import _ from 'lodash'
    import * as types from '../store/mutation-types'
    import MediaRow from './MediaRow.vue'
    import MediaFolder from './MediaFolder.vue'
    import MediaItem from './MediaItem.vue'
    import MediaModal from './MediaModal.vue'
    import Dropzone from 'vue2-dropzone'

    export default {
        computed: mapGetters({
            isLoading: 'isLoading',
            activeFolder: 'activeFolder',
            allFolders: 'allFolders',
            childFolders: 'childFolders',
            childItems: 'childItems',
            activeItem: 'activeItem'
        }),
        data: () => {
            return {
                searchQuery: ''
            }
        },
        created () {
            this.$store.dispatch('getFolders')
        },
        methods: {
            search: _.debounce(function () {
                this.$store.dispatch('searchItems', this.searchQuery)
            }, 500)
        },
        watch: {
            searchQuery () {
                this.$store.dispatch('isLoading', true);

                if (!this.searchQuery.length) {
                    this.$store.dispatch('selectFolder', this.activeFolder);
                    return true
                }

                this.search()
            }
        },
        components: {
            MediaRow,
            MediaFolder,
            MediaItem,
            MediaModal
        }
    }
</script>
