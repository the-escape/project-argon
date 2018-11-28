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

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    components: {
        'validation': Validation
    },
    computed: {
        valueObj: function () {
            let value
            let field
            if(this.comboId){
                const combo = this.$store.getters.getField(this.comboId)
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
                if(combo && combo.values.length){
                    const values = combo.values.filter(value => value.id === this.comboItemId)

                    if(values.length && values[0][this.fieldId]){
                        return values[0][this.fieldId][0]
                    }
                }
            }else{
                field = this.$store.getters.getField(this.fieldId)

                if(field.values.length){
                    return field.values[0]
                }
            }
        },
        checked: function () {
            let value
            let field
            if(this.comboId){
                const combo = this.$store.getters.getField(this.comboId)
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
                if(combo && combo.values.length){
                    const values = combo.values.filter(value => value.id === this.comboItemId)

                    if(values.length && values[0][this.fieldId]){
                        value = values[0][this.fieldId][0].value
                    }
                }
            }else{
                field = this.$store.getters.getField(this.fieldId)

                if(field.values.length){
                    value = field.values.map(value => value.value)[0]
                }
            }

            if(value === ''){
                return +field.options.settings.initial_value
            }else{
                return value || 0
            }
        }
    },
    methods: {
        onChange: function(valueObj, newValue){
            valueObj.value = !newValue ? 1 : 0

            if(this.comboId){
                this.$store.commit('updateComboFieldValue', {
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    newValue: valueObj
                })
            } else {
                this.$store.commit('updateValue', {
                    fieldID: this.fieldId,
                    newValue: valueObj
                })
            }
        }
    }
}
</script>
