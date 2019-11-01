<template>
    <div class="c-media-library__directory-view" v-bar>
        <div>
            <div class="c-media-library__breadcrumbs" v-if="active.isSet()">
                <drop
                    v-for="folder of active.breadcrumbs()"
                    :key="folder.id"
                    @dragover="crumbDragOver(folder)"
                    @dragleave="crumbDragLeave(folder)"
                    @drop="crumbHandleDrop(folder, ...arguments)"
                    @dragend="crumbDragLeave(folder)"
                >
                    <button :class="{'drag-over': folder.dragOver }" @click="folderSelected(folder)">
                        {{ folder.name }}
                    </button>
                </drop>
            </div>

            <div class="c-media-library__info">
                <div class="o-info" data-balloon-length="large" data-balloon="ctrl click or shift to select multiple items. double click on folder names to edit them." data-balloon-pos="left">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#info"></use>
                    </svg>
                </div>
            </div>

            <div class="c-media-library__grid-wrap">
                <file-list v-bind:items="active.items" v-bind:folders="active.children" ref="fileList" />
                <drop
                    @dragover="dragOver"
                    @dragleave="dragLeave"
                    @drop="handleDrop(...arguments)"
                    @dragend="dragLeave"
                >
                    <div class="c-media-library__delete-container" data-balloon-pos="left" data-balloon="To delete items, drag them over">
                        <div class="c-media-library__delete" :class="{ 'is-dragged-over': deleteHover }">
                            <svg>
                                <use xlink:href="/argon/images/svgicons.svg#delete"></use>
                            </svg>
                        </div>
                    </div>
                </drop>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import FileList from './FileList.vue'
import { setTimeout } from 'timers';

export default {
    data() {
        return {
            deleteHover: false
        }
    },
    components: {
        FileList
    },
    computed: {
        ...mapState(['active', 'back'])
    },
    methods: {
        folderSelected(folder) {
            this.$store.dispatch('folderSelected', {folder})
        },
        dragOver: function () {
            this.deleteHover = true
        },
        dragLeave: function () {
            this.deleteHover = false
        },
        handleDrop: function ({ highlighted: {items, folders }, item, folder }) {
            this.deleteHover = false

            if(!items.length && item){
                items = [item]
            }

            if(!folders.length && folder){
                folders = [folder]
            }

            this.$store.dispatch('remove', { items, folders })
            this.$refs.fileList.unhighlightItems()
        },
        crumbDragOver (folderItem) {
            folderItem.dragOver = true
        },
        crumbDragLeave (folderItem) {
            folderItem.dragOver = false
        },
        crumbHandleDrop(destinationFolder, { highlighted: {items, folders }, item, folder }) {
            destinationFolder.dragOver = false

            if(!items.length && item){
                items = [item]
            }

            if(!folders.length && folder){
                folders = [folder]
            }

            folders = folders.filter(folder => folder.id !== destinationFolder.id)

            this.$store.dispatch('move', {
                destinationFolder,
                items,
                folders
            })
        }
    }
}
</script>
