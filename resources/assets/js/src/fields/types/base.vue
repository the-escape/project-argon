<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName">{{ name }}</label>
            <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
                <template slot-scope="{ valueObj }">
                    <input-icon :pre-icon="icons.preIcon" :post-icon="icons.postIcon">
                        <input :type="type" :id="inputName" :name="inputName" :value="valueObj.value" v-on:keyup.stop="updateValue(valueObj, $event.target.value)">
                    </input-icon>
                </template>
            </multi>
        </validation>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import InputIcon from './util/input-icon.vue'
import Validation from './util/validation.vue'
import Multi from './util/multi.vue'

import { mapGetters } from 'vuex'

export default {
    props: ['fieldId', 'icons', 'type', 'comboId', 'comboItemId'],
    components: {
        'input-icon': InputIcon,
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
    },
    computed: {
        field: function () {
            if(this.comboId){
                return this.$store.getters.getComboField(this.comboId, this.fieldId)
            }
            return this.$store.getters.getField(this.fieldId)
        },
        inputName: function () {
            return `field[${this.fieldId}]`
        },
        name: function () {
            let field
            if (this.comboId) {
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            } else {
                field = this.$store.getters.getField(this.fieldId)
            }
            if(field){
                return field.options.name
            }
        },
        errors: function() {
            if(this.comboId){
                const comboItem = this.$store.getters.getField(this.comboId)
                if(comboItem.errors.length){
                    const errors =  comboItem.errors.filter(errorsObj => errorsObj.id === this.comboItemId)
                    if(errors.length && errors[0][this.fieldId]){
                        return errors[0][this.fieldId]
                    }
                }
                return []
            }

            const field = this.$store.getters.getField(this.fieldId)
            return field.errors
        }
    }
}
</script>

