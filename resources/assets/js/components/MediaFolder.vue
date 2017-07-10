<template>
    <div class="media__item media__item--folder"
        v-on:click="select()">
        <div class="media__asset media__asset--folder">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 85.04 56.69"><path d="M79.3 9.77H42.2a5.41 5.41 0 0 1-3.56-1.33L29.88.76a3.1 3.1 0 0 0-2-.76H3.54A3.49 3.49 0 0 0 0 3.42v47.73a5.66 5.66 0 0 0 5.74 5.54H79.3a5.64 5.64 0 0 0 5.7-5.54V15.32a5.64 5.64 0 0 0-5.7-5.55z"/></svg>
            <span>{{ folder.numberOfChildren }}</span>
        </div>
        <span class="media__name">{{ folder.name | length }}</span>
    </div>
</template>

<script>
    export default {
        name: 'media-folder',
        props: ['folder'],
        methods: {
            select () {
                this.$store.dispatch('selectFolder', this.folder)
            }
        }
    }
</script>
