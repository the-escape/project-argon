<template>
    <li>
        <a href="#"
           v-bind:class="isActive()"
           v-on:click="select()">{{ folder.name }}</a>
    </li>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        props: ['folder'],
        computed: mapGetters({
            activeFolder: 'activeFolder'
        }),
        methods: {
            select () {
                this.$store.dispatch('selectFolder', this.folder)
            },
            isActive () {
                return this.activeFolder === this.folder ? 'media__folder media__folder--active' : 'media__folder'
            }
        }
    }
</script>
