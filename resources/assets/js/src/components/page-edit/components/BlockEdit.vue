<template>
    <div class="c-block">
        <input type="hidden" :name="renderInputName" value="1">
        <input type="checkbox" checked hidden :name="renderInputName" value="1">
        <div class="c-block__edit">
            <div class="c-block__edit-btn" @click="editBlock($event)"><span>Edit block content</span></div>
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
        <div class="c-block__action-list">
            <button class="c-block__action" @click="deleteBlock($event)" v-if="block.isRenderable && block.isSortable">
                <div class="c-block__icon">
                    <svg><use xlink:href="/argon/images/svgicons.svg#arrow-right"></use></svg>
                </div>
            </button>
            <div class="c-block__action c-block__action--no-hover" v-if="!block.isRenderable && !block.isSortable">
                <div class="c-block__icon">
                    <svg><use xlink:href="/argon/images/svgicons.svg#lock"></use></svg>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BlockValues from '../mixins/BlockValues.vue'

export default {
    props: ['block'],
    mixins: [BlockValues],
    methods: {
        deleteBlock: function (evt) {
            evt.preventDefault()
            this.$emit('delete', this.block.id)
        },
        editBlock: function (evt) {
            evt.preventDefault()
            this.$emit('edit', this.block.id, this.block.name)
        },
        preventDefault (evt) {
            evt.preventDefault()
        }
    }
}
</script>
