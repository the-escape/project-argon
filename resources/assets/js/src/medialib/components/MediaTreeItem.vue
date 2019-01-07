<template>

    <li v-on:click.stop="folderSelected(folder)" :class="{ 'media-tree--active':folder.active }">

        <drop class="drop media-tree__item" @drop="handleDrop({f: folder.id}, ...arguments)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 85.04 56.69"><path d="M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"/></svg>
            <span>{{ folder.name }}</span>
        </drop>

        <ul class="media-tree__items" v-if="folder.children && folder.children.length">
            <MediaTreeItem v-for="child in folder.children" :key="child.id" v-bind:folder="child" />
        </ul>

    </li>

</template>

<script>
    import MediaTreeItem from "./MediaTreeItem.vue"
    import {Drop} from "vue-drag-drop";

    export default {
        name: 'MediaTreeItem',
        props: ['folder'],
        components: {
            MediaTreeItem,
            Drop
        },
        methods: {
            folderSelected(folder) {
                this.$store.dispatch('folderSelected', folder)
            },
            handleDrop(data, transferData, nativeEvent) {
                console.log(data);
                console.log(transferData);
                // alert(`You dropped with data: ${JSON.stringify(data)}`);
            }
        }
    }
</script>
