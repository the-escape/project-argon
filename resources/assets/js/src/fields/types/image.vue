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
                                <input type="text" :id="inputName + '[alt]'" :name="inputName + '[alt]'" :value="valueObj.value && valueObj.value.alt"  v-on:keyup.stop="updateAlt(valueObj, $event.target.value)">

                                <input type="hidden" :id="inputName + '[width]'" :name="inputName + '[width]'" :value="valueObj.value && valueObj.value.width">
                                <input type="hidden" :id="inputName + '[height]'" :name="inputName + '[height]'" :value="valueObj.value && valueObj.value.height">
                                <input type="hidden" :id="inputName + '[url]'" :name="inputName + '[url]'" :value="valueObj.value && valueObj.value.url">
                                <input type="hidden" :id="inputName + '[id]'" :name="inputName + '[id]'" :value="valueObj.value && valueObj.value.id">
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

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
    components: {
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
        },
        updateAlt: function(valueObj, newAlt){
            const newValue = Object.assign({}, valueObj.value, {alt: newAlt})
            this.updateValue(valueObj, newValue)
        },
        selectImage: function(evt, valueObj){
            evt.preventDefault()

            spawnMediaLib().then(value => {
                this.updateValue(valueObj, value)
            })
        }
    }
}

function spawnMediaLib () {
    return new Promise(resolve => {
        $('#medialib').off('hidden.bs.modal')
        $('#medialib').on('hidden.bs.modal', function () {
            const id = $(this).data('mlselect')
            let mediaValueObj

            $.ajax(argon.root() + '/media/items/' + id).done(function (r) {
                mediaValueObj = {
                    id: r.id,
                    url: r.url,
                    width: r.meta.width,
                    height: r.meta.height
                }

                resolve(mediaValueObj)
            })
        })

        $('#medialib').modal()
    })
}
</script>
