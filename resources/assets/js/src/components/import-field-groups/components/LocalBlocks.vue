<template>
    <div class="c-block-list__wrap">
        <div class="typography l-space">
            <h3>Local blocks</h3>
            <p>Import blocks from existing templates.</p>
        </div>
        <div class="c-block-list">
            <div class="c-block-list__search o-form">
                <input type="text" id="search" name="search" placeholder="Search blocks"  v-model="search">
                <div class="c-block-list__search-icon">
                    <svg><use xlink:href="/argon/images/svgicons.svg#search"></use></svg>
                </div>
            </div>
            <div class="c-block-list__container">
                <div class="c-block-list__inner-list">
                    <block v-for="block in blocks" :key="block.id" :block="block"></block>
                    <div class="c-blocks-library__no-blocks-message">No blocks found.</div>
                </div>

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
        data() {
            return {
                search: ''
            }
        },
        name: 'LocalBlocks',
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

                return blocks.filter(block => {
                    return block.name.toLowerCase().includes(this.search)
                })
            }
        }
    }
</script>

