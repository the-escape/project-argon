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
                    <button class="form__btn form__btn--small media__upload">UPLOAD MEDIA</button>
                </div>
            </div>
            <div class="media__browser">
                <div id="media__dropzone" class="media__items dropzone">
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
        <div id="media__template" style="display: none;">
            <div class="media__item dz-preview dz-file-preview dz-complete">
                <a href="#" data-toggle="modal" data-target="#media-view">
                    <img class="media__asset" data-dz-thumbnail />
                    <div class="media__name dz-filename"><span data-dz-name></span></div>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                </a>
            </div>
        </div>
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
    import Dropzone from 'dropzone'

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
                searchQuery: '',
                dropZone: {}
            }
        },
        created () {
            this.$store.dispatch('getFolders');
        },
        mounted () {
            Dropzone.autoDiscover = false;
            this.dropZone = new Dropzone('#media__dropzone', {
                url: '/admin',
                clickable: '.media__upload',
                previewTemplate: document.getElementById('media__template').innerHTML
            })
        },
        methods: {
            search: _.debounce(function () {
                this.$store.dispatch('searchItems', this.searchQuery)
            }, 500),
            showSuccess: function (file) {
                console.log(file)
            }
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
            MediaModal,
            Dropzone
        }
    }
</script>
