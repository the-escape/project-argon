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
                                <input type="text" :id="inputName + '[url]'" :name="inputName + '[url]'" :value="valueObj.value && valueObj.value.url" disabled>
                                <input type="hidden" :id="inputName + '[id]'" :name="inputName + '[id]'" :value="valueObj.value && valueObj.value.id">
                            </div>
                            <button class="o-btn o-btn--sm o-file__btn" @click="selectFile($event, valueObj)">select</button>
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
        selectFile: function(evt, valueObj){
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
                    url: r.url
                }

                resolve(mediaValueObj)
            })
        })

        $('#medialib').modal()
    })
}
</script>
