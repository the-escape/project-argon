<template>
    <li>
        <a href="#"
           v-bind:style="{ 'padding-left': getNumParents }"
           v-bind:class="isLinkActive() ? 'media__folder media__folder--active' : 'media__folder'"
           v-on:click="select()"><i></i>{{ folder.name }}</a>
        <ul v-show="isRowActive(folder)">
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
                activeFolder: 'activeFolder',
                rootFolder: 'rootFolder',
                parentFolders: 'parentFolders'
            }),
            childFolders: function () {
                return this.$store.getters.childFolders(this.folder)
            },
            getNumParents: function () {
                return (this.$store.getters.getNumParents(this.folder) * 10) + 10 + 'px'
            }
        },
        methods: {
            select () {
                this.$store.dispatch('selectFolder', this.folder)
            },
            isLinkActive () {
                return this.activeFolder === this.folder
            },
            isRowActive (folder) {

                let rowActive = this.parentFolders.find(function (parent) {
                    return parent === folder.id
                });

                return rowActive || this.rootFolder === folder || this.isLinkActive()
            }
        },
        components: {
            'media-row': MediaRow
        }
    }
</script>
