<template>
    <div>
        <div class="o-multi" v-if="isMultiple">
            <div class="o-multi__track">
                <draggable v-model="values" :options="{ group: { pull:true, put:true }, animation: 150, handle: '.js-multi-drag' }">
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
import ConfirmBtn from './confirm-btn.vue'

export default {
    components:{
        'confirm-btn': ConfirmBtn
    },
    props: ['inputName', 'fieldId'],
    methods: {
        addEmptyValue: function (){
            this.$store.commit('addValue', {
                fieldID: this.fieldId,
                valueObj: {
                    value: ''
                }
            })
        },
        deleteValue: function(valueID) {
            this.$store.commit('removeValue', {
                fieldID: this.fieldId,
                valueID
            })
        },
        duplicateValue: function(valueID) {
            const val = this.values.filter(value => value.id === valueID)
            let duplicateVal = {}
            if(val.length){
                duplicateVal = Object.assign({}, val[0])
            }

            this.$store.commit('addValue', {
                fieldID: this.fieldId,
                valueObj: duplicateVal
            })
        }
    },
    computed: {
        isMultiple: function () {
            const field = this.$store.getters.getField(this.fieldId)
            return field.options.settings.multiple
        },
        singleValue: function() {
            const field = this.$store.getters.getField(this.fieldId)
            if(field && field.values[0]){
                return field.values[0]
            }
            return ''
        },
        values: {
            get() {
                const field = this.$store.getters.getField(this.fieldId)
                if(field){
                    return field.values
                }
                return []
            },
            set(values) {
                this.$store.commit('updateValues', {
                    fieldID: this.fieldId,
                    newVales: values
                })
            }
        }
    }
}
</script>
