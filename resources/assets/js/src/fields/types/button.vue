<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName + '[label]'">{{ name }}</label>
            <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
                <template slot-scope="{ valueObj }">
                    <div class="o-form__vertical-list">
                        <input-icon :pre-icon="labelIcon.preIcon" :post-icon="labelIcon.postIcon">
                            <input type="text" :id="inputName + '[label]'" :name="inputName + '[label]'" :value="valueObj.value && valueObj.value.label" v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'label')">
                        </input-icon>
                        <input-icon :pre-icon="urlIcon.preIcon" :post-icon="urlIcon.postIcon">
                            <input type="text" :id="inputName + '[url]'" :name="inputName + '[url]'" :value="valueObj.value && valueObj.value.url" v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'url')">
                        </input-icon>
                        <input-icon :pre-icon="classIcon.preIcon" :post-icon="classIcon.postIcon">
                            <input type="text" :id="inputName + '[class]'" :name="inputName + '[class]'" :value="valueObj.value && valueObj.value.class" v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'class')">
                        </input-icon>
                        <input-icon :pre-icon="idIcon.preIcon" :post-icon="idIcon.postIcon">
                            <input type="text" :id="inputName + '[id]'" :name="inputName + '[id]'" :value="valueObj.value && valueObj.value.id" v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'id')">
                        </input-icon>
                        <input-icon :pre-icon="targetIcon.preIcon" :post-icon="targetIcon.postIcon">
                            <input type="text" :id="inputName + '[target]'" :name="inputName + '[target]'" :value="valueObj.value && valueObj.value.target" v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'target')">
                        </input-icon>
                    </div>
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
import FieldValues from './mixins/field-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    data() {
        return {
            labelIcon: {
                preIcon: {
                    text: 'Label'
                },
                postIcon: false
            },
            urlIcon: {
                preIcon: {
                    text: 'Url'
                },
                postIcon: false
            },
            classIcon: {
                preIcon: {
                    text: 'Class'
                },
                postIcon: false
            },
            idIcon: {
                preIcon: {
                    text: 'ID'
                },
                postIcon: false
            },
            targetIcon: {
                preIcon: {
                    text: 'Target'
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
