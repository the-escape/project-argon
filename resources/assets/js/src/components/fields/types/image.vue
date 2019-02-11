<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName + '[alt]'">{{ name }}</label>
            <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
                <template slot-scope="{ valueObj }">
                    <div class="o-file">
                        <div class="o-file__preview">
                            <div class="o-file__preview-wrap">
                                <img :src="valueObj.value.url || ''">
                            </div>
                        </div>
                        <div class="o-file__help-text">
                            <div class="o-form-icon">
                                <div class="o-form-icon__icon">
                                    <span>Alt</span>
                                </div>
                                <input type="text" :id="inputNameMultiValue + `[${valueObj.id}][alt]`" :name="inputNameMultiValue + `[${valueObj.id}][alt]`" :value="valueObj.value && valueObj.value.alt"  v-on:keyup.stop="updateAlt(valueObj, $event.target.value)">

                                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][width]`" :name="inputNameMultiValue + `[${valueObj.id}][width]`" :value="valueObj.value && valueObj.value.width">
                                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][height]`" :name="inputNameMultiValue + `[${valueObj.id}][height]`" :value="valueObj.value && valueObj.value.height">
                                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][url]`" :name="inputNameMultiValue + `[${valueObj.id}][url]`" :value="valueObj.value && valueObj.value.url">
                                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][id]`" :name="inputNameMultiValue + `[${valueObj.id}][id]`" :value="valueObj.value && valueObj.value.id">
                            </div>
                            <button class="o-btn o-btn--sm o-file__btn" @click="selectImage($event, valueObj)">select</button>
                        </div>
                    </div>
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
import { setupMedialibPicker, PickMedia } from '../../medialib'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    components: {
        'validation': Validation,
        'multi': Multi
    },
    created() {
        setupMedialibPicker()
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
        },
        updateAlt: function(valueObj, newAlt){
            const newValue = Object.assign({}, valueObj.value, {alt: newAlt})
            this.updateValue(valueObj, newValue)
        },
        selectImage: function(evt, valueObj){
            evt.preventDefault()

            PickMedia().then(value => {
                this.updateValue(valueObj, value)
            })
        }
    }
}
</script>
