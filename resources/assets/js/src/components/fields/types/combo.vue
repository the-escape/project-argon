<template>
    <div class="o-combo o-form__group">
        <div class="o-combo__head">
            <div class="o-combo__label">{{comboField.options.name}}</div>
        </div>
        <div class="o-combo__track">
            <draggable v-model="items" :options="{ group: { pull:true, put:true }, animation: 150, handle: '.js-combo-drag' }">
                <div class="o-combo__item" v-for="item in items" :key="item.id" :id="'combo-' + item.id">
                    <div class="o-combo__header">
                        <button class="o-combo__drag-handle js-combo-drag" v-if="isMultiple" @click="toggleBodyHide($event, item.id)">
                            <div class="o-combo__drag-wrap">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
                                </svg>
                            </div>
                        </button>
                        <div class="o-combo__title js-combo-title" v-if="isMultiple">Item {{ item.id + 1 }}</div>
                        <div class="o-combo__actions" v-if="isMultiple">
                            <confirm-btn @delete="deleteItem(item.id)" @duplicate="duplicateItem(item.id)"></confirm-btn>
                        </div>
                    </div>
                    <div class="o-combo__body" :style="{ display: isHidingBody ? 'none' : 'block' }">
                        <div class="o-combo__form">
                            <types v-for="field in comboFields" :key="field.id" :field="field" :combo-id="fieldId" :combo-item-id="item.id"></types>
                        </div>
                    </div>
                </div>
            </draggable>
        </div>
        <div class="o-combo__foot">
            <button class="o-btn o-btn--sm" v-if="isMultiple" @click="addEmptyItem($event)">Add {{comboField.options.comboAddName}}</button>
        </div>
    </div>
</template>

<script>
import { deepClone } from '../../../util'
import ComfirmBtn from '../../commonComponents/confirm-btn.vue'
import Jump from '../../../ui/jump'

export default {
    name: 'combo',
    props: ['fieldId'],
    data() {
        return {
            isHidingBody: false
        }
    },
    components: {
        'confirm-btn': ComfirmBtn
    },
    created: function () {
        if(!this.items.length){
            this.addEmptyItem()
        }
    },
    watch: {
        items: function(){
            if(!this.items.length){
                this.addEmptyItem()
            }
        }
    },
    methods: {
        toggleBodyHide: function(evt, scrollID) {
            evt.preventDefault()

            this.isHidingBody = !this.isHidingBody

            setTimeout(() => {
                requestAnimationFrame(() => {
                    Jump.jump('#combo-' + scrollID)
                })
            }, 0)
        },
        deleteItem: function (comboItemID) {
            this.$store.commit('removeComboItem', {
                comboID: this.fieldId,
                comboItemID
            })
        },
        duplicateItem: function (comboItemID) {
            const comboField = this.$store.getters.getField(this.fieldId)
            const val = comboField.values.filter(comboValueObj => comboValueObj.id === comboItemID)
            if(!val.length){
                console.warn('could not find value to duplicate')
                return
            }

            const duplicate = deepClone(val[0])
            this.$store.commit('addComboItemValue', {
                comboID: this.fieldId,
                newValueObj: duplicate
            })
        },
        addEmptyItem: function (evt) {
            evt && evt.preventDefault()

            const comboField = this.$store.getters.getField(this.fieldId)
            const emptyValue = deepClone(comboField.emptyValue)
            this.$store.commit('addComboItemValue', {
                comboID: this.fieldId,
                newValueObj: emptyValue
            })
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
        items: {
            get () {
                const comboField = this.$store.getters.getField(this.fieldId)
                return comboField.values
            },
            set (values) {
                this.$store.commit('updateComboItemValues', {
                    comboID: this.fieldId,
                    newValues: values
                })
            }
        }
    }
}
</script>
