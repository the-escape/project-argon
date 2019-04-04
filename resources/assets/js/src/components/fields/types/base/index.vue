<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName">{{ name }}</label>
            <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
                <template slot-scope="{ valueObj }">
                    <field-base :icons="icons" :type="type" :value-obj="valueObj" :input-name="inputName" @change="updateValue(valueObj, $event)" />
                </template>
            </multi>
        </validation>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import Validation from '../util/validation.vue'
import Multi from '../util/multi.vue'
import FieldValues from '../mixins/field-values.vue'
import Base from './base.vue'

export default {
    props: ['fieldId', 'icons', 'type', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    components: {
        'field-base': Base,
        'validation': Validation,
        'multi': Multi
    },
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

