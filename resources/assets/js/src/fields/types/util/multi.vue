<template>
    <div>
        <div class="o-multi" v-if="isMultiple">
            <div class="o-multi__track">
                <draggable v-model="values" @end="onMove" :options="{ group: { pull:true, put:true }, animation: 150, handle: '.js-multi-drag' }">
                    <div class="o-multi__item" v-for="value in values" :key="value.id">
                        <div class="o-multi__item-wrap">
                            <button class="o-multi__drag-handle js-multi-drag">
                                <div class="o-multi__drag-wrap">
                                    <svg>
                                        <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
                                    </svg>
                                </div>
                            </button>

                            <slot :value-obj="value"></slot>

                            <div class="o-multi__actions">
                                <confirm-btn v-on:delete="deleteValue(value.id)" v-on:duplicate="duplicateValue(value.id)"></confirm-btn>
                            </div>
                        </div>
                    </div>
                </draggable>
            </div>
            <div class="o-multi__foot">
                <button v-on:click="addEmptyValue" class="o-btn o-btn--sm">Add</button>
            </div>
        </div>
        <template v-if="!isMultiple">
            <slot :value-obj="singleValue"></slot>
        </template>
    </div>
</template>

<script>
import { EventBus } from './bus'
import ConfirmBtn from './confirm-btn.vue'
import { deepClone } from '../../../util'

export default {
    name: 'multi',
    components:{
        'confirm-btn': ConfirmBtn
    },
    props: ['inputName', 'fieldId', 'comboId', 'comboItemId'],
    methods: {
        onMove: function () {
            let name = 'move-' + this.fieldId
            if(this.comboId){
                name = 'move-' + this.fieldId + '-' + this.comboId + '-' + this.comboItemId
            }
            EventBus.$emit(name)
        },
        addEmptyValue: function (){
            if(this.comboId){
                const field = this.$store.getters.getComboField(this.comboId, this.fieldId)
                const newEmptyValue = deepClone(field.emptyValue)
                this.$store.commit('addComboFieldValue', {
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    valueObj: newEmptyValue
                })
            }else{
                const field = this.$store.getters.getField(this.fieldId)
                const newEmptyValue = deepClone(field.emptyValue)
                this.$store.commit('addValue', {
                    fieldID: this.fieldId,
                    valueObj: newEmptyValue
                })
            }
        },
        deleteValue: function(valueID) {
            if(this.comboId){
                this.$store.commit('removeComboFieldValue', {
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    valueID
                })
            } else {
                this.$store.commit('removeValue', {
                    fieldID: this.fieldId,
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
                this.$store.commit('addComboFieldValue', {
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    valueObj: duplicateVal
                })
            }else{
                this.$store.commit('addValue', {
                    fieldID: this.fieldId,
                    valueObj: duplicateVal
                })
            }
        }
    },
    computed: {
        isMultiple: function () {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            } else {
                field = this.$store.getters.getField(this.fieldId)
            }
            return field.options.settings.multiple
        },
        singleValue: function() {
            if(this.comboId){
                const comboField = this.$store.getters.getField(this.comboId)
                if(comboField && comboField.values.length){
                    const values = comboField.values.filter(value => value.id === this.comboItemId)
                    if(values.length && values[0][this.fieldId] && values[0][this.fieldId][0]){
                        return values[0][this.fieldId][0]
                    }
                }
            }

            const field = this.$store.getters.getField(this.fieldId)
            if(field && field.values[0]){
                return field.values[0]
            }

            return ''
        },
        values: {
            get() {
                if(this.comboId){
                    const comboField = this.$store.getters.getField(this.comboId)
                    if(comboField && comboField.values.length){
                        const values = comboField.values.filter(value => value.id === this.comboItemId)
                        if(values.length && values[0][this.fieldId]){
                            return values[0][this.fieldId]
                        }
                    }
                }

                const field = this.$store.getters.getField(this.fieldId)
                if(field){
                    return field.values
                }
                return []
            },
            set(values) {
                if(this.comboId){
                    this.$store.commit('updateComboFieldValues', {
                        fieldID: this.fieldId,
                        comboID: this.comboId,
                        comboItemId: this.comboItemId,
                        newValues: values
                    })
                }else{
                    this.$store.commit('updateValues', {
                        fieldID: this.fieldId,
                        comboID: this.comboId,
                        comboItemId: this.comboItemId,
                        newValues: values
                    })
                }

            }
        }
    }
}
</script>
