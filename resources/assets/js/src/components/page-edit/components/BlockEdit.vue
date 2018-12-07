<template>
    <div class="c-block">
        <input type="hidden" :name="renderInputName" value="1">
        <input type="checkbox" checked hidden :name="renderInputName" value="1">
        <div class="c-block__edit">
            <button class="c-block__edit-btn" @click="editBlock($event)"><span>Edit block content</span></button>
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
            <confirm-btns :hide-duplicate="true" is-block="true" @delete="deleteBlock" v-if="block.isRenderable && block.isSortable" />
            <button class="c-block__drag-handle" v-if="block.isSortable" @click="preventDefault($event)">
                <div class="c-block__icon">
                    <svg><use xlink:href="/argon/images/svgicons.svg#hamburger"></use></svg>
                </div>
            </button>
        </div>
    </div>
</template>

<script>
import BlockValues from '../mixins/BlockValues.vue'
import ConfirmBtns from '../../commonComponents/confirm-btn.vue'

export default {
    props: ['block'],
    mixins: [BlockValues],
    components: {
        ConfirmBtns
    },
    methods: {
        deleteBlock: function () {
            this.$emit('delete', this.block.id)
        },
        editBlock: function (evt) {
            evt.preventDefault()
            this.$emit('edit', this.block.id)
        },
        preventDefault (evt) {
            evt.preventDefault()
        }
    }
}
</script>
