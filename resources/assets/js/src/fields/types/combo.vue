<template>
    <div class="o-combo o-form__group l-full js-combo">
        <div class="o-combo__head">
            <div class="o-combo__label">{name}</div>
            <button class="o-btn o-btn--sm o-btn--primary js-combo-add">Add {comboAddName}</button>
        </div>
        <div class="o-combo__track js-combo-track">
            <div class="o-combo__item">
                <div class="o-combo__header">
                    <button class="o-combo__drag-handle js-combo-drag">
                        <div class="o-combo__drag-wrap">
                            <svg>
                                <use xlink:href="/images/svgicons.svg#reorder"></use>
                            </svg>
                        </div>
                    </button>
                    <div class="o-combo__title js-combo-title">Combo Item</div>
                    <div class="o-combo__actions">
                        <confirm-btn v-on:delete="deleteValue()" v-on:duplicate="duplicateValue()"></confirm-btn>
                    </div>
                </div>
                <div class="o-combo__body">
                    <div class="o-combo__form">



                    </div>
                </div>
            </div>
        </div>
        <div class="o-combo__foot">
            <button class="o-btn o-btn--sm o-btn--primary js-combo-add">Add {comboAddName}</button>
        </div>
    </div>
</template>

<script>
import ComfirmBtn from './util/confirm-btn.vue'

export default {
    components: {
        'confirm-btn': ComfirmBtn
    },
    mothods: {
        deleteItem: function () {
            console.log('delete item')
        },
        duplicateItem: function () {
            console.log('duplicate item')
        }
    }
}
</script>
