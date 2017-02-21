<template>
    <div class="media">
        <div class="media__tree">
            <div class="media__scroll">
                <ul>
                    <media-row
                            v-bind:folder="rootFolder">
                    </media-row>
                </ul>
            </div>
        </div>
        <div class="media__right">
            <div class="media__scroll">
                <div class="media__header">
                    <form>
                        <div class="form__group">
                            <label for="search" class="sr-only">Search library</label>
                            <input v-model="searchFilter" id="search" type="text" class="form__text icon" placeholder="Search library">
                            <span class="icon search"></span>
                        </div>
                        <div class="form__group">
                            <label for="type" class="sr-only">Media Type</label>
                            <select v-model="typeFilter" id="type" class="form__select">
                                <option></option>
                                <option value="all">All</option>
                                <option value="files">Files</option>
                                <option value="folders">Folders</option>
                            </select>
                        </div>
                    </form>
                    <div class="media__actions">
                        <h1 v-if="!searchFilter.length">{{ activeFolder.name }}</h1>
                        <h1 v-else>Search: {{ searchFilter }}</h1>
                        <button class="form__btn form__btn--small media__upload">UPLOAD MEDIA</button>
                    </div>
                </div>
                <div class="media__browser">
                    <div class="media__items">
                        <div class="media__item media__item--folder" v-on:click="setCreating" v-if="!searchFilter.length">
                            <div class="media__asset media__asset--folder">
                                <img src="/argon/assets/img/icons/folder-add.png" width="100%" alt="add">
                            </div>
                            <span class="media__name">New folder</span>
                        </div>
                        <div class="media__item media__item--folder" v-if="isCreating && !searchFilter.length">
                            <div class="media__asset media__asset--folder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 85.04 56.69"><path d="M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"/></svg>
                            </div>
                            <span class="media__name">
                                <label for="name" class="sr-only">Folder name</label>
                                <input v-model="folderName" id="name" type="text" v-on:keyup.enter="storeFolder" autofocus>
                            </span>
                        </div>
                        <media-folder
                                v-if="(!searchFilter.length && !isLoading) && typeFilter !== 'files'"
                                v-for="folder in childFolders"
                                v-bind:folder="folder">
                        </media-folder>
                        <media-item
                                v-if="typeFilter !== 'folders'"
                                v-for="item in childItems"
                                v-bind:item="item">
                        </media-item>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isLoading" class="media__loading"></div>
        <media-modal></media-modal>
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

    export default {
        name: 'media',
        computed: {
            ...mapGetters({
                isLoading: 'isLoading',
                activeFolder: 'activeFolder',
                rootFolder: 'rootFolder',
                childItems: 'childItems',
                activeItem: 'activeItem',
                isCreating: 'isCreating'
            }),
            childFolders: function () {
                return this.$store.getters.childFolders(this.activeFolder)
            }
        },
        data: () => {
            return {
                searchFilter: '',
                typeFilter: '',
                folderName: ''
            }
        },
        created () {
            this.$store.dispatch('getFolders');
        },
        mounted () {
            let self = this;
            $('.media__scroll').scrollbar();
            $('.media .form__select').select2({
                placeholder: 'Media type',
                minimumResultsForSearch: Infinity,
                width: '100%'
            }).on('change', function (e) {
                self.mediaType = $(this).val();
            });
        },
        methods: {
            doSearch: _.debounce(function () {
                this.$store.dispatch('searchItems', this.searchFilter)
            }, 500),
            setCreating () {
                this.$store.commit(types.MEDIA_FOLDERS_STORE)
            },
            storeFolder () {

                if (!this.folderName.length) {
                    return false;
                }

                this.$store.dispatch('storeFolder', {
                    parentId: this.activeFolder.id,
                    name: this.folderName
                })
            }
        },
        watch: {
            searchFilter () {
                this.$store.dispatch('isLoading', true);

                if (!this.searchFilter.length) {
                    this.$store.dispatch('selectFolder', this.activeFolder);
                    return true
                }

                this.doSearch()
            }
        },
        components: {
            'media-row': MediaRow,
            'media-folder': MediaFolder,
            'media-item': MediaItem,
            'media-modal': MediaModal
        }
    }
</script>
