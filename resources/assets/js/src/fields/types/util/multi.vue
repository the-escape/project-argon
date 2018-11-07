<template>
    <div>
        <div class="o-multi" v-if="isMultiple">
            <div class="o-multi__track">
                <div class="o-multi__item" v-for="value in values" :key="value.id">
                    <div class="o-multi__item-wrap">
                        <button class="o-multi__drag-handle js-multi-drag">
                            <div class="o-multi__drag-wrap">
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#reorder"></use>
                                </svg>
                            </div>
                        </button>

                        <slot :value="value.val"></slot>

                        <div class="o-multi__actions">
                            <confirm-btn v-on:delete="deleteValue(value.id)" v-on:duplicate="duplicateValue(value.id)"></confirm-btn>
                        </div>
                    </div>
                </div>
                <div class="o-multi__foot" slot="footer">
                    <button v-on:click="addValue" class="o-btn o-btn--sm">Add</button>
                </div>
            </div>
        </div>
        <template v-if="!isMultiple">
            <slot :value="singleValue"></slot>
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
        addValue: function (){
            this.values.push('')
        },
        deleteValue: function(index) {
            this.values.splice(index, 1)
        },
        duplicateValue: function(index) {
            const val = this.values[index]
            let duplicateVal
            if(typeof val === 'object'){
                duplicateVal = Object.assign({}, val)
            }else{
                duplicateVal = val
            }

            this.values.push(duplicateVal)
        }
    },
    computed: {
        field: function () {
            return this.$store.getters.getField(this.fieldId)
        },
        isMultiple: function () {
            const field = this.$store.getters.getField(this.fieldId)
            return field.options.settings.multiple
        },
        singleValue:{
            get() {
                const field = this.$store.getters.getField(this.fieldId)
                if(this.values[0] && this.values[0].val){
                    return this.values[0].val
                }
                return ''
            },
            set(value) {
                this.$store.commit('setValues', this.fieldId, [{val: value, id: 0}])
            }
        },
        values: {
            get() {
                const field = this.$store.getters.getField(this.fieldId)
                return field.values
            },
            set(values) {
                this.$store.commit('setValues', this.fieldId, values)
            }
        }
    }
}
</script>
