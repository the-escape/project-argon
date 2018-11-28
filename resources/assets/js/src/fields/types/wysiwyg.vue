<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName">{{ name }}</label>
            <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
                <template slot-scope="{ valueObj }">
                    <single-wysiwyg :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :name="inputName" :value-obj="valueObj" v-on:update="updateValue(valueObj, $event)" />
                </template>
            </multi>
        </validation>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import Validation from './util/validation.vue'
import Multi from './util/multi.vue'
import FieldValues from './mixins/field-values.vue'
import SingleWysiwyg from './single-wysiwyg.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    components: {
        'validation': Validation,
        'multi': Multi,
        'single-wysiwyg': SingleWysiwyg
    },
    mixins: [FieldValues],
    methods: {
        updateValue: function(valueObj, newValue) {
            valueObj.value = newValue

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

