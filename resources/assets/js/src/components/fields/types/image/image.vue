<template>
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
                <input type="text" :id="inputNameMultiValue + `[${valueObj.id}][alt]`" :name="inputNameMultiValue + `[${valueObj.id}][alt]`" v-model="alt">

                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][width]`" :name="inputNameMultiValue + `[${valueObj.id}][width]`" :value="valueObj.value && valueObj.value.width">
                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][height]`" :name="inputNameMultiValue + `[${valueObj.id}][height]`" :value="valueObj.value && valueObj.value.height">
                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][url]`" :name="inputNameMultiValue + `[${valueObj.id}][url]`" :value="valueObj.value && valueObj.value.url">
                <input type="hidden" :id="inputNameMultiValue + `[${valueObj.id}][id]`" :name="inputNameMultiValue + `[${valueObj.id}][id]`" :value="valueObj.value && valueObj.value.id">
            </div>
            <button class="o-btn o-btn--sm o-file__btn" @click.prevent="selectImage">select</button>
        </div>
        <button v-if="!field.options.settings.multiple" @click.prevent="clearValue" data-balloon="Delete" title="Delete" class="o-confirm-btn"><svg><use xlink:href="/argon/images/svgicons.svg#delete"></use></svg></button>
    </div>
</template>

<script>
import FieldValues from '../mixins/field-values.vue'
import { setupMedialibPicker, PickMedia } from '../../../medialib'

export default {
    props: ['groupId', 'fieldId', 'comboId', 'comboItemId', 'valueObj'],
    mixins: [FieldValues],
    data() {
        return {
            loading: true,
            alt: ''
        }
    },
    created() {
        setupMedialibPicker()
    },
    mounted() {
        if(this.valueObj.value){
            this.alt = this.valueObj.value.alt
        }
        this.loading = false
    },
    watch: {
        alt: function (newValue) {
            if(this.loading){
                return
            }
            newValue = Object.assign({}, this.valueObj.value, {alt: newValue})
            this.updateValue(newValue)
        }
    },
    methods: {
        updateValue: function(newValue) {
            this.valueObj.value = newValue

            if(this.comboId){
                this.$store.commit('fields/updateComboItemFieldValue', {
                    groupID: this.groupId,
                    fieldID: this.fieldId,
                    comboID: this.comboId,
                    comboItemId: this.comboItemId,
                    newValue: this.valueObj
                })
            } else {
                this.$store.commit('fields/updateValue', {
                    groupID: this.groupId,
                    id: this.fieldId,
                    newValue: this.valueObj
                })
            }
        },
        clearValue: function(){
            this.updateValue({
                id: '',
                alt: '',
                url: ''
            })
            this.alt = ''
        },
        selectImage: function(){
            PickMedia().then(value => {
                const newValue = Object.assign({}, this.valueObj.value, value)
                this.updateValue(newValue)
            })
        }
    }
}
</script>
