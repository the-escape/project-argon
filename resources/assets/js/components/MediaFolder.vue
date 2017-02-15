<template>
    <div class="media__item media__item--folder"
        v-on:click="select()">
        <div class="media__asset media__asset--folder">
        </div>
        <span class="media__name">{{ folder.name | length }}</span>
    </div>
</template>

<script>
    export default {
        props: ['folder'],
        methods: {
            select () {
                this.$store.dispatch('selectFolder', this.folder)
            }
        }
    }
</script>
