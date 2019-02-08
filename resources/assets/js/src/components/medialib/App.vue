<template>
    <div>
        <div class="c-media-library__picker" v-if="isPicker && isOpen">
            <main class="c-container c-container--main">
                <media-library />
            </main>
        </div>
        <media-library v-if="!isPicker" />
    </div>
</template>

<script>
import { mapState } from 'vuex'
import {
    MediaLibrary
} from './components'

export default {
    created () {
        this.$store.dispatch('loadLibrary');

        window.addEventListener('popstate', evt => {
            if(evt.state && evt.state.folderID) {
                this.$store.dispatch('folderSelectByID', evt.state.folderID)
            }
        })

        this.$store.state.isPicker = this.$root.$data.isPicker

        this.$root.$on('open', () => {
            this.isOpen = true
        })

        this.$root.$on('pick', () => {
            this.isOpen = false
        })
    },
    mounted() {
        const folderUrlRegex = /[?&]folderID(=([^&#]*)|&|#|$)/
        let folderID = folderUrlRegex.exec(window.location.search)
        if(folderID && folderID[2]){
            this.$store.dispatch('folderSelectByID', folderID[2])
        }
    },
    data() {
        return {
            isOpen: false
        }
    },
    computed: {
        isPicker: function () {
            return this.$store.state.isPicker
        },
        showMediaLib: function () {
            if(!this.isPicker){
                return true
            }

            return this.isPicker && this.isOpen
        }
    },
    components: {
        MediaLibrary
    }
}
</script>
