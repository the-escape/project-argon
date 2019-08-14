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
                            <types v-for="field in comboFields" :group-id="groupId" :key="field.id" :field="field" :combo-id="fieldId" :combo-item-id="item.id"></types>
                        </div>
                    </div>
                </div>
            </draggable>
        </div>
        <div class="o-combo__foot">
            <button class="o-btn o-btn--sm" v-if="isMultiple" @click.prevent="addEmptyItem">Add {{comboField.options.comboAddName}}</button>
        </div>
    </div>
</template>

<script>
import { deepClone } from '../../../util'
import ComfirmBtn from '../../commonComponents/confirm-btn.vue'
import Jump from '../../../ui/jump'

export default {
    name: 'combo',
    props: ['groupId', 'fieldId'],
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
            this.$store.dispatch('fields/removeComboItem', {
                groupID: this.groupId,
                id: this.fieldId,
                valueID: comboItemID
            })
        },
        duplicateItem: function (comboItemID) {
            const valueObj = this.$store.getters['fields/getComboItem'](this.groupId, this.fieldId, comboItemID)

            if(!valueObj){
                console.warn('could not find value to duplicate')
                return
            }

            const duplicate = deepClone(valueObj)
            this.$store.commit('fields/addComboItemValue', {
                groupID: this.groupId,
                id: this.fieldId,
                valueObj: duplicate
            })
        },
        addEmptyItem: function () {
            const comboField = this.$store.getters['fields/getCombo'](this.groupId, this.fieldId)
            const emptyValue = deepClone(comboField.emptyValue)
            this.$store.commit('fields/addComboItemValue', {
                groupID: this.groupId,
                id: this.fieldId,
                valueObj: emptyValue
            })
        }
    },
    computed: {
        comboField: function () {
            return this.$store.getters['fields/getCombo'](this.groupId, this.fieldId)
        },
        comboFields: function () {
            return this.$store.getters['fields/getComboFields'](this.groupId, this.fieldId)
        },
        isMultiple: function () {
            return this.$store.getters['fields/isComboMultiple'](this.groupId, this.fieldId)
        },
        items: {
            get () {
                return this.$store.getters['fields/getValues'](this.groupId, [this.fieldId])
            },
            set (values) {
                this.$store.dispatch('fields/updateComboItemValues', {
                    groupID: this.groupId,
                    id: this.fieldId,
                    newValues: values
                })
            }
        }
    }
}
</script>
