<template>
    <div class="c-blocks-library__item js-get-library-block show" :class="{ 'editing': isEdited }" :data-block-id="block.id" @dblclick="getBlock">
        <div class="c-blocks-library__item-name">{{ block.name }}</div>
        <div class="c-blocks-library__item-image" :style="bgImage"></div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import { mapState, mapMutations } from 'vuex'

    export default {
        name: 'Block',
        props: ['block'],
        methods: {
            ...mapMutations([
                'getBlockFromLibrary'
            ]),
            getBlock: function() {
                this.getBlockFromLibrary(this.block)
            }
        },
        computed: {
            ...mapState({
                selectedBlock: 'block'
            }),
            isEdited: function() {
                return this.selectedBlock && this.selectedBlock.id === this.block.id
            },
            bgImage: function() {
                return 'background-image: url(' + this.block.image + ')'
            }
        }
    }
</script>

