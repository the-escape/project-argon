<template>
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
                        v-model="latitude"
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
                        v-model="longitude"
                    >
                </validation>
            </div>
        </div>
    </div>
</template>

<script>
import Validation from '../util/validation.vue'
import FieldValues from '../mixins/field-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
    mixins: [FieldValues],
    data() {
        return {
            loading: true,
            latitude: '',
            longitude: ''
        }
    },
    mounted() {
        if(this.valueObj.value){
            this.latitude = this.valueObj.value.latitude
            this.longitude = this.valueObj.value.longitude
        }
        this.loading = false
    },
    watch: {
        latitude: function(newValue) {
            if(this.loading){
                return
            }
            this.updateValue(newValue, 'latitude')
        },
        longitude: function(newValue) {
            if(this.loading){
                return
            }
            this.updateValue(newValue, 'longitude')
        }
    },
    components: {
        'validation': Validation
    },
    methods: {
        updateValue: function(newValue, prop) {
            if(!this.valueObj.value){
                this.valueObj.value = {}
            }
            this.valueObj.value[prop] = newValue

            if(this.comboId){
                this.$store.commit('updateComboFieldValue', {
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    newValue: this.valueObj
                })
            } else {
                this.$store.commit('updateValue', {
                    fieldID: this.fieldId,
                    newValue: this.valueObj
                })
            }
        }
    }
}
</script>
