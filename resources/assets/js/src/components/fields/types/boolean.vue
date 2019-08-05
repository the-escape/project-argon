<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <div class="o-form__list">
                <div class="o-switch">
                    <label>
                        <input type="hidden" :name="inputName" :value="checked">
                        <input type="checkbox" :id="inputName" :checked="checked" @change="onChange(valueObj, checked)">
                        <label>
                            <div class="o-switch__text" data-yes="on" data-no="off"></div>
                        </label>
                    </label>
                    <label :for="inputName">{{ name }}</label>
                </div>
            </div>
        </validation>
    </div>
</template>

<script>
import Validation from './util/validation.vue'
import FieldValues from './mixins/field-values.vue'
import ValueObjs from './mixins/value-objs.vue'

export default {
    props: ['groupId', 'fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues, ValueObjs],
    components: {
        'validation': Validation
    },
    computed: {
        valueObj: function () {
            return this.$store.getters['fields/getSingleValue'](this.groupId, [this.fieldId, this.comboId])
        },
        checked: function () {
            let value = this.$store.getters['fields/getSingleValue'](this.groupId, [this.fieldId, this.comboId])
            let initialValue = this.$store.getters['fields/getFieldOption'](this.groupId, [this.fieldId, this.comboId], 'settings.initial_value')
            if(value.value === ''){
                return +initialValue
            }

            return +value.value
        }
    },
    methods: {
        onChange: function(valueObj, newValue){
            valueObj.value = !newValue ? 1 : 0

            if(this.comboId){
                this.$store.commit('fields/updateComboItemFieldValue', {
                    groupID: this.groupId,
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    newValue: valueObj
                })
            } else {
                this.$store.commit('fields/updateValue', {
                    groupID: this.groupId,
                    id: this.fieldId,
                    newValue: valueObj
                })
            }
        }
    }
}
</script>
