<template>
    <div>
        <div class="c-import-field-groups__title">
            <h4>Blocks Library</h4>
            <p>Import blocks stored in the cloud.</p>
        </div>
        <div class="c-import-field-groups__search">
            <div class="o-form__group o-form__group--icon-btn">
                <input type="text" class="js-search-blocks-library" name="cloud_search" placeholder="Search field groups" @keyup="search">
                <button class="js-search-blocks-library-trigger">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#search"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div class="c-import-field-groups__column">
            <div class="c-blocks-library js-blocks-library">

                <block v-for="block in blocks" :key="block.id" :block="block"></block>

                <div class="c-blocks-library__no-blocks-message">No blocks in the library.</div>
            </div>
            <div class="c-blocks-library__item--template js-block-template">
                <div class="c-blocks-library__item-name"></div>
                <div class="c-blocks-library__item-image" style="background-image: url()"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import Block from './Block.vue'

    export default {
        components: {
            Block
        },
        name: 'BlocksLibrary',
        methods: {
            search: function(evt) {
                // todo: filter the list
                console.log('searching...')
            }
        },
        computed: {
            blocks: function() {
                return this.$store.state.blocks
            }
        }
    }
</script>

