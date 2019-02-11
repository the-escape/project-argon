<template>
    <div>
        <transition name="fade">
            <div class="c-media-library__picker" v-if="isPicker && isOpen">
                <div class="c-media-library__picker-bg" @click="closePicker"></div>
                <div class="c-media-library__picker-btn">
                    <button @click.prevent="closePicker">
                        <svg>
                            <use xlink:href="/argon/images/svgicons.svg#cross-circle"></use>
                        </svg>
                    </button>
                </div>
                <main class="c-container c-container--main">
                    <media-library />
                </main>
            </div>
        </transition>
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

        window.addEventListener('keydown', evt => {
            if(evt.key === "Escape"){
                this.closePicker()
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
    },
    methods: {
        closePicker () {
            this.isOpen = false
            this.$root.$emit('pick', null)
        }
    }
}
</script>
