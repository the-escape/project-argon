<template>
    <div class="c-media-library__directory-tree" v-bar>
        <div>
            <div class="c-media-library__scroller">
                <ul class="c-directory-tree">
                    <li>
                        <div class="c-directory-tree__content" :class="{ 'is-active': recentUploads.show }">
                            <button @click="openRecentUploads">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#folder"></use>
                                </svg>
                                <span>Recent uploads</span>
                            </button>
                        </div>
                    </li>
                    <tree-item :folder="folder" :recent-uploads-show="recentUploads.show" />
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import TreeItem from "./TreeItem.vue"

export default {
    components: {
        TreeItem,
    },
    computed: {
        ...mapState([
            'folder',
            'recentUploads'
        ])
    },
    methods: {
        openRecentUploads: function () {
            this.$store.dispatch('recentUploads')
        }
    }
}
</script>
