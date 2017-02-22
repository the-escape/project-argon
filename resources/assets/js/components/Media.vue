<template>
    <div class="media">
        <div class="media__tree">
            <div class="media__scroll">
                <ul>
                    <media-row v-bind:folder="rootFolder"></media-row>
                </ul>
            </div>
        </div>
        <div class="media__right">
            <div class="media__scroll">
                <media-header></media-header>
                <div class="media__browser">
                    <div class="media__items">
                        <div class="media__item media__item--folder" v-on:click="creating" v-if="!searching">
                            <div class="media__asset media__asset--folder">
                                <img src="/argon/assets/img/icons/folder-add.png" width="100%" alt="add">
                            </div>
                            <span class="media__name">New folder</span>
                        </div>
                        <div class="media__item media__item--folder" v-if="isCreating && !searching">
                            <div class="media__asset media__asset--folder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 85.04 56.69">
                                    <path d="M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"/>
                                </svg>
                            </div>
                            <span class="media__name">
                                <label for="name" class="sr-only">Folder name</label>
                                <input v-model="folderName" v-on:keyup.enter="storeFolder" id="name" type="text" autofocus>
                            </span>
                        </div>
                        <media-folder
                                v-if="(!searching || !isLoading) && filter !== 'files'"
                                v-for="folder in childFolders"
                                v-bind:folder="folder">
                        </media-folder>
                        <media-item
                                v-if="filter !== 'folders'"
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
    import * as types from '../store/mutation-types'
    import MediaHeader from './MediaHeader.vue'
    import MediaRow from './MediaRow.vue'
    import MediaFolder from './MediaFolder.vue'
    import MediaItem from './MediaItem.vue'
    import MediaModal from './MediaModal.vue'

    export default {
        name: 'media',
        computed: {
            ...mapGetters({
                isLoading: 'isLoading',
                searching: 'searching',
                filter: 'filter',
                rootFolder: 'rootFolder',
                childItems: 'childItems',
                isCreating: 'isCreating',
                activeFolder: 'activeFolder'
            }),
            childFolders: function () {
                return this.$store.getters.childFolders(this.activeFolder)
            }
        },
        data: () => {
            return {
                folderName: ''
            }
        },
        created () {
            this.$store.dispatch('getFolders');
        },
        methods: {
            creating () {
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
        components: {
            'media-header': MediaHeader,
            'media-row': MediaRow,
            'media-folder': MediaFolder,
            'media-item': MediaItem,
            'media-modal': MediaModal
        }
    }
</script>
