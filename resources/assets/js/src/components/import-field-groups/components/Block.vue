<template>
    <div class="c-block c-block-library" :class="{ 'editing': isEdited }" :data-block-id="block.id">
        <div class="c-block__edit">
            <div class="c-block__edit-btn" @click="getBlock"><span>Load block schema</span></div>
            <div class="c-block__image">
                <img :src="block.image" v-if="block.image" :alt="block.name">
                <div class="c-block__empty-image" v-if="!block.image">
                    <svg><use xlink:href="/argon/images/svgicons.svg#file-input"></use></svg>
                </div>
            </div>
            <div class="c-block__title">
                <span>{{ block.name }}</span>
            </div>
        </div>
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

