<template>
    <li>
        <a href="#"
           v-bind:class="isActive()"
           v-on:click="select()">{{ folder.name }}</a>
        <ul>
            <media-row
                    v-for="childFolder in childFolders"
                    v-bind:folder="childFolder">
            </media-row>
        </ul>
    </li>
</template>

<script>
    import { mapGetters } from 'vuex'
    import MediaRow from './MediaRow.vue'

    export default {
        name: 'media-row',
        props: ['folder'],
        computed: {
            ...mapGetters({
                activeFolder: 'activeFolder'
            }),
            childFolders: function () {
                return this.$store.getters.childFolders(this.folder)
            }
        },
        methods: {
            select () {
                this.$store.dispatch('selectFolder', this.folder)
            },
            isActive () {
                return this.activeFolder === this.folder ? 'media__folder media__folder--active' : 'media__folder'
            }
        },
        components: {
            'media-row': MediaRow
        }
    }
</script>
