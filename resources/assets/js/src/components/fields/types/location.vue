<template>
    <div class="o-form__group">
        <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
            <template slot-scope="{ valueObj }">
                <div class="o-form__set">
                    <div class="o-form__set-title">
                        <label :for="inputNameMultiValue + `[${valueObj.id}][latitude]`">{{ name }}</label>
                    </div>

                    <div class="o-form__set-container">
                        <div class="o-form__group">
                            <validation
                                :status-error="errors && errors.latitude"
                                :input-name="inputNameMultiValue + `[${valueObj.id}][latitude]`"
                            >
                                <label :for="inputNameMultiValue + `[${valueObj.id}][latitude]`">Latitude</label>
                                <input
                                    type="text"
                                    :id="inputNameMultiValue + `[${valueObj.id}][latitude]`"
                                    :name="inputNameMultiValue + `[${valueObj.id}][latitude]`"
                                    :value="valueObj.value && valueObj.value.latitude"
                                    v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'latitude')"
                                >
                            </validation>
                        </div>
                        <div class="o-form__group">
                            <validation
                                :status-error="errors && errors.longitude"
                                :input-name="inputNameMultiValue + `[${valueObj.id}][longitude]`"
                            >
                                <label :for="inputNameMultiValue + `[${valueObj.id}][longitude]`">Longitude</label>
                                <input
                                    type="text"
                                    :id="inputNameMultiValue + `[${valueObj.id}][longitude]`"
                                    :name="inputNameMultiValue + `[${valueObj.id}][longitude]`"
                                    :value="valueObj.value && valueObj.value.longitude"
                                    v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'longitude')"
                                >
                            </validation>
                        </div>
                    </div>
                </div>
            </template>
        </multi>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import InputIcon from './util/input-icon.vue'
import Validation from './util/validation.vue'
import Multi from './util/multi.vue'
import FieldValues from './mixins/field-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    data() {
        return {
            latIcon: {
                preIcon: {
                    text: 'Lat'
                },
                postIcon: false
            },
            lngIcon: {
                preIcon: {
                    text: 'Lng'
                },
                postIcon: false
            }
        }
    },
    components: {
        'input-icon': InputIcon,
        'validation': Validation,
        'multi': Multi
    },
    methods: {
        updateValue: function(valueObj, newValue, prop) {
            if(!valueObj.value){
                valueObj.value = {}
            }
            valueObj.value[prop] = newValue

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
