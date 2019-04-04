<template>
    <textarea :id="inputName" :name="inputName" v-model="value"></textarea>
</template>

<script>
import FieldValues from '../mixins/field-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
    mixins: [FieldValues],
    data() {
        return {
            loading: true,
            value: ''
        }
    },
    mounted() {
        this.value = this.valueObj.value
        this.loading = false
    },
    watch: {
        value: function(newValue) {
            if(this.loading){
                return
            }

            this.valueObj.value = newValue

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

