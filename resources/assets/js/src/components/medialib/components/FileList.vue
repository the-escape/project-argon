<template>
    <div :class="`c-file-list c-file-list--${layout}`">
        <template v-for="folderItem in folders">
            <drop
                @dragover="dragOver(folderItem)"
                @dragleave="dragLeave(folderItem)"
                @drop="handleDrop(folderItem, ...arguments)"
                @dragend="dragLeave(folderItem)"
                v-if="!folderItem.hide"
                :key="folderItem.id"
            >
                <drag
                    effect-allowed="move"
                    drop-effect="move"
                    :transfer-data="{ highlighted, folder: folderItem }"
                    @dragstart="dragStart(folderItem)"
                    @dragend="dragEnd(folderItem)"
                    :image-x-offset="65"
                    :image-y-offset="65"
                >
                    <div slot="image" class="c-file-list__drag-view">
                        <div class="c-file-list__image">
                            <svg>
                                <use xlink:href="/argon/images/svgicons.svg#folder"></use>
                            </svg>
                        </div>
                    </div>
                    <div
                        class="c-file-list__item c-file-list__item--folder"
                        :class="{'is-highlighted': folderItem.highlight, 'is-dragover': folderItem.dragOver}"
                    >
                        <button
                            class="c-file-list__btn"
                            @click="highlightItem($event, folderItem)"
                            @dblclick="folderSelected(folderItem)"
                        >
                            <div class="c-file-list__image">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#folder"></use>
                                </svg>
                            </div>
                            <div class="c-file-list__label">
                                <span>{{ folderItem.name }}</span>
                            </div>
                        </button>
                        <confirm-btn
                            v-if="layout === 'list'"
                            hideDuplicate="true"
                            @delete="deleteFolder(folderItem)"
                        />
                    </div>
                </drag>
            </drop>
        </template>

        <template v-for="item in items">
            <drag
                effect-allowed="move"
                drop-effect="move"
                :transfer-data="{ highlighted, item }"
                @dragstart="dragStart(item)"
                @dragend="dragEnd(item)"
                :key="`item-${item.item.id}`"
                :image-x-offset="layout === 'list' ? 15 : 65"
                :image-y-offset="layout === 'list' ? 15 : 65"
                v-if="!item.hide"
            >
                <div slot="image" class="c-file-list__drag-view">
                    <div class="c-file-list__image">
                        <img :src="item.getUrl()" alt="item.getName()">
                    </div>
                </div>
                <div
                    class="c-file-list__item"
                    :class="{ 'is-highlighted': item.highlight, 'is-dragging': item.dragging }"
                >
                    <button
                        class="c-file-list__btn"
                        @dblclick="editItem(item)"
                        @click="highlightItem($event, item)"
                    >
                        <div class="c-file-list__image">
                            <img :src="item.getUrl()" alt="item.getName()">
                        </div>
                        <div class="c-file-list__label">
                            <span>{{ item.getName() }}</span>
                        </div>
                    </button>
                    <confirm-btn
                        v-if="layout === 'list'"
                        hideDuplicate="true"
                        @delete="deleteItem(item)"
                    />
                </div>
            </drag>
        </template>
    </div>
</template>

<script>
    import { fromEvent } from 'rxjs'
    import { filter } from 'rxjs/operators'
    import { mapState } from 'vuex'
    import { Drag, Drop } from 'vue-drag-drop'

    import { pickImage } from '../api/media'

    export default {
        data () {
            return {
                key: "",
                lastHighlightIndex: false
            }
        },
        props: ['items', 'folders'],
        computed: {
            ...mapState([
                'layout',
                'data',
                'search',
                'layout',
                'folder'
            ]),
            combinedItems: function (){
                return [...this.folders, ...this.items].map((item, index) => {
                     item.index = index
                     return item
                 })
            },
            highlighted: function () {
                return {
                    items: this.items.filter(el => el.highlight),
                    folders: this.folders.filter(el => el.highlight)
                }
            }
        },
        components: {
            Drag,
            Drop
        },
        created (){
            fromEvent(document, 'click')
                .pipe(filter(evt => !evt.target.classList.contains('c-file-list__btn')))
                .subscribe(this.unhighlightItems.bind(this))
        },
        methods: {
            folderSelected(folder) {
                this.$store.dispatch('folderSelected', {folder})
            },
            editItem(item){
                if(this.$store.state.isPicker){
                    pickImage(item.item.id, mediaObj => {
                        this.$root.$emit('pick', mediaObj)
                    })
                }else{
                    this.$store.dispatch('editItem', item)
                }
            },
            highlightItem(evt, item) {
                if(!evt.ctrlKey && !evt.shiftKey){
                    this.unhighlightItems()
                }

                item.highlight = true

                if(evt.shiftKey && ~this.lastHighlightIndex){
                    const currentIndex = item.index

                    this.combinedItems.forEach((item, index) => {
                        item.highlight = index >= this.lastHighlightIndex && index <= currentIndex
                    })
                }

                this.lastHighlightIndex = item.index
            },
            unhighlightItems () {
                this.combinedItems.forEach(item => item.highlight = false)
            },
            dragStart (item) {
                item.dragging = true
                item.highlight = true
            },
            dragEnd (item) {
                item.dragging = false
                item.highlight = false
            },
            dragOver (folderItem) {
                folderItem.dragOver = true
            },
            dragLeave (folderItem) {
                folderItem.dragOver = false
            },
            handleDrop(destinationFolder, { highlighted: {items, folders }, item, folder }) {
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
            },
            deleteFolder (folder) {
                this.$store.dispatch('removeFolder', folder)
            },
            deleteItem (item) {
                this.$store.dispatch('removeItem', item)
            }
        }
    }
</script>

<style>
    .drag-image {
        color: #000;
    }
</style>
