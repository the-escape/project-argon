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
                :ref="`folder-${folderItem.id}`"
            >
                <drag
                    effect-allowed="move"
                    drop-effect="move"
                    :transfer-data="{ highlighted, folder: folderItem }"
                    @dragstart="dragStart(folderItem)"
                    @dragend="dragEnd(folderItem)"
                    :image-x-offset="dragOffset"
                    :image-y-offset="dragOffset"
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
                        </button>
                        <button
                            class="c-file-list__edit"
                            @click="highlightItem($event, folderItem)"
                            @dblclick="editFolder(folderItem)"
                            v-if="!folderItem.editing"
                        >
                            <div class="c-file-list__label">
                                <span>{{ folderItem.name }}</span>
                            </div>
                        </button>
                        <div class="c-file-list__edit c-file-list__edit--editing" v-else>
                            <div class="c-file-list__label">
                                <input type="text"
                                    v-model="folderItem.name"
                                    :ref="`folderEdit-${folderItem.id}`"
                                    @keydown.enter="comfirmEditFolder(folderItem)"
                                    @keydown.escape="closeEditFolder(folderItem)">
                                <button
                                    class="c-file-list__edit-confirm"
                                    @click="comfirmEditFolder(folderItem)"
                                >
                                    <svg>
                                        <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                                    </svg>
                                </button>
                                <button class="c-file-list__edit-close" @click="closeEditFolder(folderItem)">
                                    <svg>
                                        <use xlink:href="/argon/images/svgicons.svg#cross"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <confirm-btn
                            v-if="layout === 'list'"
                            hideDuplicate="true"
                            @delete="deleteFolder(folderItem)"
                        />
                    </div>
                </drag>
            </drop>
        </template>

        <div
            class="c-file-list__item c-file-list__item--folder c-file-list__item--empty-folder"
            ref="newFolder"
            :class="{ 'is-editing': editingNewFolder }"
            v-if="showAddFolder"
        >
            <button
                class="c-file-list__btn"
                @click="newFolder"
            >
                <div class="c-file-list__image">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#folder-add"></use>
                    </svg>
                </div>
            </button>
            <button
                class="c-file-list__edit"
                @click="newFolder"
                v-if="!editingNewFolder"
            >
                <div class="c-file-list__label">
                    <span>Add new folder</span>
                </div>
            </button>
            <div class="c-file-list__edit c-file-list__edit--editing" v-else>
                <div class="c-file-list__label">
                    <input type="text" v-model="newFolderName" ref="newFolder" @keydown.escape="closeNewFolder" @keydown.enter="comfirmNewFolder">
                    <button class="c-file-list__edit-confirm" @click="comfirmNewFolder()">
                        <svg>
                            <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                        </svg>
                    </button>
                    <button class="c-file-list__edit-close" @click="closeNewFolder">
                        <svg>
                            <use xlink:href="/argon/images/svgicons.svg#cross"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <template v-for="item in items">
            <drag
                effect-allowed="move"
                drop-effect="move"
                :transfer-data="{ highlighted, item }"
                @dragstart="dragStart(item)"
                @dragend="dragEnd(item)"
                :key="`item-${item.item.id}`"
                :image-x-offset="dragOffset"
                :image-y-offset="dragOffset"
                v-if="!item.hide"
                :ref="`item-${item.item.id}`"
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
                            <div class="c-file-list__image-bg"></div>
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
    import { EventBus } from '../util/bus'
    import { scrollTo } from '../util/scrollTo'

    import { pickImage } from '../api/media'

    export default {
        data () {
            return {
                key: "",
                lastHighlightIndex: false,
                editingNewFolder: false,
                newFolderName: ''
            }
        },
        props: {
            items: {
                type: Array,
                default: function () {
                    return []
                }
            },
            folders: {
                type: Array,
                default: function () {
                    return []
                }
            },
            showAddFolder: {
                type: Boolean,
                default: function () {
                    return true
                }
            }
        },
        computed: {
            ...mapState([
                'layout',
                'data',
                'search',
                'layout',
                'active',
                'folder',
                'newUploadIds'
            ]),
            dragOffset: function (){
                return 'list' ? 15 : 65
            },
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
                .pipe(filter(evt => {
                    const contains =
                    evt.target.classList.contains('c-file-list__btn') ||
                    evt.target.classList.contains('c-file-list__edit')
                    return !contains
                }))
                .subscribe(this.unhighlightItems.bind(this))

            EventBus.$on('addFolder', this.newFolder.bind(this))
        },
        watch: {
            items: function () {
                this.$nextTick(function () {
                    if(this.newUploadIds.length){
                        let element = this.$refs[`item-${this.newUploadIds[0]}`]
                        if(element.length){
                            element = element && element[0] && element[0].$el
                            const container = element.closest('.vb-content')
                            scrollTo(container, element, () => {
                                this.$store.dispatch('clearNewUploadIDs')
                            })
                        }
                    }
                })
            }
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
            },
            editFolder (folder) {
                folder.editing = true
                folder.originalName = folder.name

                this.$nextTick(function() {
                    let element = this.$refs[`folderEdit-${folder.id}`]
                    element = this.$refs[`folderEdit-${folder.id}`] && this.$refs[`folderEdit-${folder.id}`][0]
                    if(element){
                        element.focus()
                    }
                })
            },
            comfirmEditFolder (folder) {
                folder.editing = false
                this.$store.dispatch('editFolder', folder)
            },
            closeEditFolder (folder) {
                folder.editing = false
            },
            newFolder () {
                this.editingNewFolder = true

                this.$nextTick(function() {
                    const element = this.$refs['newFolder']
                    if(!element){
                        return
                    }
                    const container = element.closest('.vb-content')
                    scrollTo(container, element, () => {
                        element.focus()
                    })
                })
            },
            comfirmNewFolder () {
                this.editingNewFolder = false
                this.$store.dispatch('createFolder', { name: this.newFolderName, parent: this.active })
                this.newFolderName = ''
            },
            closeNewFolder () {
                this.editingNewFolder = false
            }
        }
    }
</script>
