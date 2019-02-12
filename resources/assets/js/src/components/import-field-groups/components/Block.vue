<template>
    <div class="c-blocks-library__item js-get-library-block show" :data-block-id="block.id" @click="getBlock">
        <div class="c-blocks-library__item-name">{{ block.name }}</div>
        <div class="c-blocks-library__item-image" :style="bgImage"></div>
    </div>
</template>

<script>
    export default {
        name: 'Block',
        props: ['block'],
        methods: {
            getBlock: function() {
                if (this.isLocal) {
                    // TODO export local block and add to editor
                } else {
                    // TODO api call to get block and add it to editor
                }
            }
        },
        computed: {
            bgImage: function() {
                return 'background-image: url(' + this.block.image + ')'
            }
        }
    }
</script>

