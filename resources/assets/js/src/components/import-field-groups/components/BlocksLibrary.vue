<template>
    <div class="c-block-list__wrap">
        <div class="typography l-space">
            <h3>Blocks Library</h3>
            <p>Import blocks stored in the cloud.</p>
        </div>
        <div class="c-block-list">
            <div class="c-block-list__search o-form">
                <input type="text" id="search" name="search" placeholder="Search blocks" v-model="search">
                <div class="c-block-list__search-icon">
                    <svg><use xlink:href="/argon/images/svgicons.svg#search"></use></svg>
                </div>
            </div>
            <div class="c-block-list__container">
                <div class="c-block-list__inner-list">
                    <block v-for="block in filteredBlocks" :key="block.id" :block="block"></block>
                    <div v-if="!filteredBlocks.length" class="c-blocks-library__no-blocks-message">No blocks found.</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Block from './Block.vue'
    import { mapState } from 'vuex'

    export default {
        components: {
            Block
        },
        data() {
            return {
                search: ''
            }
        },
        name: 'BlocksLibrary',
        computed: {
            ...mapState([
                'blocks',
                'block'
            ]),
            filteredBlocks: function () {
                return this.blocks.filter(block => {
                    return block.name.toLowerCase().includes(this.search)
                })
            }
        }
    }
</script>

