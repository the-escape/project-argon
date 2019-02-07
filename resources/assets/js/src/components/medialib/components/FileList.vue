<template>
    <div :class="`c-file-list c-file-list--${layout}`">
        <drop
            v-for="folderItem in folders"
            :key="folderItem.id"
            @dragover="dragOver(folderItem)"
            @dragleave="dragLeave(folderItem)"
            @drop="handleDrop(folderItem, ...arguments)"
            @dragend="dragLeave(folderItem)"
        >
            <button
                class="c-file-list__item c-file-list__item--folder"
                :class="{'is-highlighted': folderItem.highlight, 'is-dragover': folderItem.dragOver}"
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
        </drop>

        <drag
            effect-allowed="move"
            drop-effect="move"
            :transfer-data="highlightedItems"
            @dragstart="dragStart(item)"
            @dragend="dragEnd(item)"
            v-for="item in items"
            :key="`item-${item.item.id}`"
            :image-x-offset="65"
            :image-y-offset="65"
        >
            <div slot="image" class="c-file-list__drag-view">
                <div class="c-file-list__image">
                    <img :src="item.getUrl()" alt="item.getName()">
                </div>
            </div>
            <button
                class="c-file-list__item"
                :class="{ 'is-highlighted': item.highlight, 'is-dragging': item.dragging }"
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
        </drag>
    </div>
</template>

<script>
    import { fromEvent } from 'rxjs'
    import { filter } from 'rxjs/operators'
    import { mapState } from 'vuex'
    import { Drag, Drop } from 'vue-drag-drop'

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
            highlightedItems: function () {
                return this.combinedItems.filter(el => el.highlight)
            }
        },
        components: {
            Drag,
            Drop
        },
        created (){
            fromEvent(document, 'click')
                .pipe(filter(evt => !evt.target.classList.contains('c-file-list__item')))
                .subscribe(this.unhighlightItems.bind(this))
        },
        methods: {
            folderSelected(folder) {
                this.$store.dispatch('folderSelected', folder)
            },
            editItem(item){
                this.$store.dispatch('editItem', item)
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
            handleDrop(destinationFolder, transferData) {
                destinationFolder.dragOver = false
                let payload = {
                    folder: destinationFolder,
                    items: transferData,
                    currentFolder: this.folder
                }
                this.$store.dispatch('moveItems', payload)
            }
        }
    }
</script>

<style>
    .drag-image {
        color: #000;
    }
</style>
