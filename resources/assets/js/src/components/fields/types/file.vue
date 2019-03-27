<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName + '[alt]'">{{ name }}</label>
            <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
                <template slot-scope="{ valueObj }">
                    <div class="o-file">
                        <div class="o-file__preview">
                            <div class="o-file__preview-wrap">
                                <svg><use xlink:href="/argon/images/svgicons.svg#files" /></svg>
                            </div>
                        </div>
                        <div class="o-file__help-text">
                            <div class="o-form-icon">
                                <div class="o-form-icon__icon">
                                    <span>Url</span>
                                </div>
                                <input type="text" :value="valueObj.value && valueObj.value.url" disabled>
                                <input type="hidden" :id="inputName" :name="inputName" :value="valueObj.value && valueObj.value.id">
                            </div>
                            <button class="o-btn o-btn--sm o-file__btn" @click="selectFile($event, valueObj)">select</button>
                        </div>
                        <button v-if="!field.options.settings.multiple" @click.prevent="clearValue(valueObj)" data-balloon="Delete" title="Delete" class="o-confirm-btn"><svg><use xlink:href="/argon/images/svgicons.svg#delete"></use></svg></button>
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
        clearValue: function(valueObj){
            this.updateValue(valueObj, {
                id: '',
                alt: '',
                url: ''
            })
        },
        selectFile: function(evt, valueObj){
            evt.preventDefault()

            PickMedia().then(value => {
                this.updateValue(valueObj, value)
            })
        }
    }
}
</script>
