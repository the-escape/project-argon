<template>
    <div>
        <div class="c-import-field-groups__title">
            <h4>Local templates</h4>
            <p>Copy field groups from another template existing in this project.</p>
        </div>
        <div class="c-import-field-groups__search">
            <div class="o-form__group o-form__group--icon-btn">
                <input type="text" class="js-search-navtree" name="local_search" placeholder="Search field groups" @keyup="search">
                <button class="js-search-navtree-trigger">
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
        </div>
    </div>
</template>

<script>
    import Block from './Block.vue'

    export default {
        components: {
            Block
        },
        name: 'LocalBlocks',
        methods: {
            search: function(evt) {
                // todo: filter the list // pottentially could be moved to a mixin later
                console.log('searching...')
            }
        },
        computed: {
            blocks: function() {
                let types = this.$store.state.types

                let blocks = types.map(type => {
                    return type.groups.map(group => {
                        return {
                            isLocal: true,
                            id: group.id,
                            type: type.id,
                            name: group.name + ' [' + type.name + ']',
                            image: group.settings.image
                        }
                    })
                }).reduce((l, n) => l.concat(n), [])

                return blocks
            }
        }
    }
</script>

