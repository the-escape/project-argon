<template>
    <div class="c-media-library__header">
        <div class="c-media-library__button-group">
            <button class="c-media-library__btn" @click="back">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#arrow-left"></use>
                </svg>
            </button>
            <button class="c-media-library__btn" @click="forwards">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#arrow-right"></use>
                </svg>
            </button>
        </div>

        <div class="c-media-library__button-group">
            <button class="c-media-library__btn" :class="{ 'is-active': layout === 'tiles' }" @click="setLayout('tiles')">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#blocks"></use>
                </svg>
            </button>
            <button class="c-media-library__btn" :class="{ 'is-active': layout === 'list' }" @click="setLayout('list')">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#list"></use>
                </svg>
            </button>
            <div class="c-media-library__search" :class="{ 'hide-icon': keywords.length || isSearchFocussed }">
                <input type="text" v-model="keywords" @focus="setSearchFocus(true)" @blur="setSearchFocus(false)">
                <div class="c-media-library__search-icon">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#search"></use>
                    </svg>
                </div>
            </div>
        </div>

        <div class="c-media-library__button-group">
            <button class="o-btn o-btn--sm" @click="createFolder(active)">Add folder</button>
            <button class="o-btn o-btn--primary o-btn--sm" @click.prevent="toggleUpload">{{uploadIsOpen ? 'Close uploads' : 'Upload media' }}</button>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import { EventBus } from '../util/bus'

export default {
    data() {
        return {
            isSearchFocussed: false
        }
    },
    computed: {
        ...mapState(['layout', 'search', 'active', 'uploadIsOpen']),
        keywords: {
            set(keywords) {
                if(!keywords.length){
                    this.search.reset()
                }else{
                    this.$store.dispatch('search', keywords)
                }
            },
            get() {
                return this.search.keywords
            }
        }
    },
    methods: {
        setSearchFocus(isFocused = true) {
            this.isSearchFocussed = isFocused
        },
        setLayout(layout) {
            this.$store.dispatch('setLayout', layout)
        },
        searchReset() {
            this.search.reset()
        },
        searchItems: function () {
            this.$store.dispatch('search', this.keywords)
        },
        createFolder(parent) {
            EventBus.$emit('addFolder')
        },
        editFolder(folder) {
            let fn = prompt("Please edit the folder name:", folder.name)
            if (fn) {
                let payload = {name: fn, folder: folder}
                this.$store.dispatch('editFolder', payload)
            }

        },
        removeFolder(active) {
            let c = confirm("Are you sure?")
            if (c === true) {
                this.$store.dispatch('removeFolder', active)
            }
        },
        toggleUpload() {
            this.$store.dispatch('toggleUploads')
        },
        back() {
            history.back();
        },
        forwards() {
            history.forward();
        }
    }
}
</script>

