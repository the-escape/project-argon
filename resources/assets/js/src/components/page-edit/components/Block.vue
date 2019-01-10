<template>
    <component v-bind:is="type" :block="block" @add="addItem" @delete="deleteItem" @edit="editBlock" />
</template>

<script>
import BlockAdd from './BlockAdd.vue'
import BlockEdit from './BlockEdit.vue'

export default {
    props: ['block'],
    components: {
        BlockAdd,
        BlockEdit
    },
    computed: {
        type: function () {
            if(!this.block.isRenderable || this.block.isRendering){
                return 'block-edit'
            }
            return 'block-add'
        }
    },
    methods: {
        addItem: function (id) {
            this.$emit('add', id)
        },
        deleteItem: function (id) {
            this.$emit('delete', id)
        },
        editBlock: function (id, name) {
            this.$emit('edit', id, name)
        }
    }
}
</script>
