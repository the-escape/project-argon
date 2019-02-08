<template>
    <li v-if="!folder.hide">
        <drop @dragover="dragOver(folder)" @dragleave="dragLeave(folder)" @dragend="dragLeave(folder)" @drop="handleDrop(folder, ...arguments)">
            <div class="c-directory-tree__content" :class="{ 'is-active': folder.active, 'is-open': folder.treeActive, 'is-dragover': folder.treeDragOver }">
                <button @click="folderSelected(folder)">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#folder"></use>
                    </svg>
                    <span>{{ folder.name }}</span>
                </button>
                <button @click="toggleChildren(folder)" class="c-directory-tree__accordion-icon" v-if="folder.children && folder.children.length">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#arrow-down"></use>
                    </svg>
                </button>
            </div>
        </drop>

        <transition enter-active-class="collapsing" leave-active-class="collapsing" @enter="enter" @afterEnter="afterEnter" @leave="leave" @afterLeave="afterLeave">
            <ul v-if="folder.children && folder.children.length && folder.treeActive">
                <tree-item v-for="child in folder.children" :key="child.id" :folder="child" />
            </ul>
        </transition>
    </li>
</template>

<script>
import { Drop } from "vue-drag-drop";

export default {
    name: 'TreeItem',
    props: ['folder'],
    components: {
        Drop
    },
    methods: {
        folderSelected(folder) {
            folder.treeActive = true
            this.$store.dispatch('folderSelected', {folder})
        },
        toggleChildren(folder) {
            folder.treeActive = !folder.treeActive
        },
        handleDrop(destinationFolder, { highlighted: {items, folders }, item, folder }) {
            destinationFolder.treeDragOver = false

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
        enter (el) {
            el.style.height = 0
            el.style.height = el.scrollHeight + 'px'
        },
        afterEnter (el) {
            el.style.height = null
        },
        leave (el) {
            el.style.height = 'auto'
            el.style.display = 'block'
            const { height } = el.getBoundingClientRect()
            el.style.height = height + 'px'
            el.style.height = 0
        },
        afterLeave (el) {
            el.style.height = null
        },
        dragOver (folder) {
            folder.treeDragOver = true
        },
        dragLeave (folder) {
            folder.treeDragOver = false
        }
    }
}
</script>
