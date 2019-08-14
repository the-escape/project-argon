<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName">{{ name }}</label>
            <flat-pickr :config="config" :name="inputName" :id="inputName" :value="singleValue.value" @on-change="onChange"></flat-pickr>
        </validation>
        <div class="o-form__help-text l-full" v-if="field.helpText" v-html="field.helpText"></div>
    </div>
</template>

<script>
import Validation from './util/validation.vue'
import FieldValues from './mixins/field-values.vue'
import ValueObjs from './mixins/value-objs.vue'
import flatPickr from 'vue-flatpickr-component'

export default {
    props: ['groupId', 'fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues, ValueObjs],
    components: {
        'validation': Validation,
        flatPickr
    },
    data () {
        return {
            defaultConfig: {
                altFormat: 'd F, Y',
                defaultDate: null,
                default: false,
                mode: 'single',
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                enableTime: false
            }
        }
    },
    watch: {
        singleValue: function () {
            if(this.singleValue.value === '' && this.config.default){
                this.updateValue(this.singleValue, new Date())
            }
        }
    },
    methods: {
        updateValue: function(valueObj, newValue) {
            valueObj.value = newValue

            if(this.comboId){
                this.$store.commit('fields/updateComboItemFieldValue', {
                    groupID: this.groupId,
                    ids: [this.fieldId, this.comboId, this.comboItemId],
                    newValue: valueObj
                })
            } else {
                this.$store.commit('fields/updateValue', {
                    groupID: this.groupId,
                    id: this.fieldId,
                    newValue: valueObj
                })
            }
        },
        onChange: function (_, strDate) {
            this.updateValue(this.singleValue, strDate)
        }
    },
    computed: {
        config: function () {
            const config = {}
            const fieldSettings = this.$store.getters['fields/getFieldOption'](this.groupId, [this.fieldId, this.comboId], 'settings')

            if(fieldSettings.time){
                config.enableTime = true
                config.altFormat = 'd F, Y h:i K'
            }

            config.default = fieldSettings.default
            if(fieldSettings.default){
                config.defaultDate = new Date()
            }

            return Object.assign(this.defaultConfig, config)
        }
    }
}
</script>
