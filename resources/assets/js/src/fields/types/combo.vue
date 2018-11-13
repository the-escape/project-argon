<template>
    <div class="o-combo o-form__group l-full">
        <div class="o-combo__head">
            <div class="o-combo__label">{{comboField.options.name}}</div>
            <button class="o-btn o-btn--sm o-btn--primary" v-if="isMultiple" v-on:click="addEmptyItem()">Add {{comboField.options.comboAddName}}</button>
        </div>
        <div class="o-combo__track">
            <draggable v-model="values" :options="{ group: { pull:true, put:true }, animation: 150, handle: '.js-combo-drag' }">
                <div class="o-combo__item" v-for="value in values" :key="value.id">
                    <div class="o-combo__header">
                        <button class="o-combo__drag-handle js-combo-drag">
                            <div class="o-combo__drag-wrap">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
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
                            <types v-for="field in comboFields" :key="field.id" :field="field" :combo-id="fieldId" :combo-value-id="value.id"></types>
                        </div>
                    </div>
                </div>
            </draggable>
        </div>
        <div class="o-combo__foot">
            <button class="o-btn o-btn--sm o-btn--primary" v-if="isMultiple" v-on:click="addEmptyItem()">Add {{comboField.options.comboAddName}}</button>
        </div>
    </div>
</template>

<script>
import ComfirmBtn from './util/confirm-btn.vue'

export default {
    name: 'combo',
    props: ['fieldId'],
    components: {
        'confirm-btn': ComfirmBtn
    },
    mothods: {
        deleteItem: function () {
            console.log('delete item')
        },
        duplicateItem: function () {
            console.log('duplicate item')
        },
        addEmptyItem: function () {
            console.log('add empty item')
        }
    },
    computed: {
        comboField: function () {
            return this.$store.getters.getField(this.fieldId)
        },
        comboFields: function () {
            const comboField = this.$store.getters.getField(this.fieldId)
            return comboField.fields
        },
        isMultiple: function () {
            const comboField = this.$store.getters.getField(this.fieldId)
            return comboField.options.settings.multiple
        },
        values: {
            get () {
                const comboField = this.$store.getters.getField(this.fieldId)
                return comboField.values
            },
            set (values) {
                this.$store.commit('updateComboValues', {
                    comboID: this.fieldId,
                    newValues: values
                })
            }
        }
    }
}
</script>
