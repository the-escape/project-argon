<template>
    <div class="c-media-library__directory-tree" v-bar>
        <ul class="c-directory-tree">
            <tree-item :folder="folder" />
        </ul>
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
                'folder'
            ])
        }
    }
</script>
