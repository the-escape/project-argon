<template>
    <li>
        <a href="#"
           v-bind:class="isActive(folder)"
           v-on:click="select(folder)">{{ folder.name }}</a>
    </li>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        props: ['folder'],
        computed: mapGetters({
            selected: 'folder'
        }),
        methods: {
            select (folder) {
                this.$store.dispatch('selectFolder', folder)
            },
            isActive (folder) {
                return this.selected === folder ? 'media__folder media__folder--active' : 'media__folder'
            }
        }
    }
</script>
