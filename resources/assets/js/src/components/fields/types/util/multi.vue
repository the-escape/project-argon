<template>
    <div>
        <div class="o-multi" v-if="isMultiple">
            <div class="o-multi__track">
                <draggable v-model="values" @end="onMove" :options="{ group: { pull:true, put:true }, animation: 150, handle: '.js-multi-drag' }">
                    <div class="o-multi__item" v-for="value in values" :key="value.id">
                        <div class="o-multi__item-wrap">
                            <button class="o-multi__drag-handle js-multi-drag" @click.prevent>
                                <div class="o-multi__drag-wrap">
                                    <svg>
                                        <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
                                    </svg>
                                </div>
                            </button>

                            <slot :value-obj="value"></slot>

                            <div class="o-multi__actions">
                                <confirm-btn @delete="deleteValue(value.id)" @duplicate="duplicateValue(value.id)"></confirm-btn>
                            </div>
                        </div>
                    </div>
                </draggable>
            </div>
            <div class="o-multi__foot">
                <button @click.prevent="addEmptyValue" class="o-btn o-btn--sm">Add</button>
            </div>
        </div>
        <template v-if="!isMultiple">
            <slot :value-obj="singleValue"></slot>
        </template>
    </div>
</template>

<script>
import { EventBus } from './bus'
import ConfirmBtn from '../../../commonComponents/confirm-btn.vue'
import { deepClone } from '../../../../util'
import valueObjs from '../mixins/value-objs.vue'

export default {
    name: 'multi',
    components:{
        'confirm-btn': ConfirmBtn
    },
    props: ['groupId', 'inputName', 'fieldId', 'comboId', 'comboItemId'],
    mixins: [valueObjs],
    methods: {
        onMove: function () {
            let name = 'move-' + this.fieldId
            if(this.comboId){
                name = 'move-' + this.fieldId + '-' + this.comboId + '-' + this.comboItemId
            }
            EventBus.$emit(name)
        },
        addEmptyValue: function (){
            const field = this.$store.getters['fields/getField'](this.groupId, [this.fieldId, this.comboId])

            if(this.comboId){
                const newEmptyValue = deepClone(field.emptyValue)
                this.$store.commit('fields/addComboItemFieldValue', {
                    groupID: this.groupId,
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemID: this.comboItemId,
                    valueObj: newEmptyValue
                })
            }else{
                const newEmptyValue = deepClone(field.emptyValue)
                this.$store.commit('fields/addValue', {
                    groupID: this.groupId,
                    id: this.fieldId,
                    valueObj: newEmptyValue
                })
            }
        },
        deleteValue: function(valueID) {
            if(this.comboId){
                this.$store.commit('fields/removeComboItemFieldValue', {
                    groupID: this.groupId,
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemID: this.comboItemId,
                    valueID
                })
            } else {
                this.$store.commit('fields/removeValue', {
                    groupID: this.groupId,
                    id: this.fieldId,
                    valueID
                })
            }
        },
        duplicateValue: function(valueID) {
            const val = this.values.filter(value => value.id === valueID)
            let duplicateVal = {}
            if(val.length){
                duplicateVal = Object.assign({}, val[0])
            }

            if(this.comboId){
                this.$store.commit('fields/addComboItemFieldValue', {
                    groupID: this.groupId,
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    valueObj: duplicateVal
                })
            }else{
                this.$store.commit('fields/addValue', {
                    groupID: this.groupId,
                    id: this.fieldId,
                    valueObj: duplicateVal
                })
            }
        }
    },
    computed: {
        isMultiple: function () {
            return this.$store.getters['fields/getFieldOption'](this.groupId, [this.fieldId, this.comboId], 'settings.multiple')
        }
    }
}
</script>
