<template>
    <div class="c-block">
        <input type="hidden" :name="renderInputName" value="0">
        <input type="checkbox" checked hidden :name="renderInputName" value="0">
        <div class="c-block__image">
            <img :src="block.image" v-if="block.image" :alt="block.name">
            <div class="c-block__empty-image" v-if="!block.image">
                <svg><use xlink:href="/argon/images/svgicons.svg#file-input"></use></svg>
            </div>
        </div>
        <div class="c-block__title">
            <span>{{ block.name }}</span>
        </div>
        <div class="c-block__action-list">
            <button class="c-block__action" @click="addBlock($event)">
                <div class="c-block__icon">
                    <svg><use xlink:href="/argon/images/svgicons.svg#add"></use></svg>
                </div>
            </button>
            <button class="c-block__drag-handle" @click="preventDefault($event)">
                <div class="c-block__icon">
                    <svg><use xlink:href="/argon/images/svgicons.svg#hamburger"></use></svg>
                </div>
            </button>
        </div>
    </div>
</template>

<script>
import BlockValues from '../mixins/BlockValues.vue'

export default {
    props: ['block'],
    mixins: [BlockValues],
    methods: {
        addBlock (evt) {
            evt.preventDefault()
            this.$emit('add', this.block.id)
        },
        preventDefault (evt) {
            evt.preventDefault()
        }
    }
}
</script>
