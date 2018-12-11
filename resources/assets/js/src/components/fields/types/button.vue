<template>
    <div class="o-form__group">
        <multi :field-id="fieldId" :combo-id="comboId" :combo-item-id="comboItemId" :input-name="inputName">
            <template slot-scope="{valueObj}">
                <div class="o-form__set">
                    <div class="o-form__set-title">
                        <label :for="inputNameMultiValue + `[${valueObj.id}][label]`">{{ name }}</label>
                    </div>

                    <div class="o-form__set-container">
                        <div class="o-form__group">
                            <validation
                                :status-error="errors && errors.label"
                                :input-name="inputNameMultiValue + `[${valueObj.id}][label]`"
                            >
                                <label :for="inputNameMultiValue + `[${valueObj.id}][label]`">Label</label>
                                <input
                                    type="text"
                                    :id="inputNameMultiValue + `[${valueObj.id}][label]`"
                                    :name="inputNameMultiValue + `[${valueObj.id}][label]`"
                                    :value="valueObj.value && valueObj.value.label"
                                    v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'label')"
                                >
                            </validation>
                        </div>
                        <div class="o-form__group">
                            <validation
                                :status-error="errors && errors.url"
                                :input-name="inputNameMultiValue + `[${valueObj.id}][url]`"
                            >
                                <label :for="inputNameMultiValue + `[${valueObj.id}][url]`">Url</label>
                                <input
                                    type="text"
                                    :id="inputNameMultiValue + `[${valueObj.id}][url]`"
                                    :name="inputNameMultiValue + `[${valueObj.id}][url]`"
                                    :value="valueObj.value && valueObj.value.url"
                                    v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'url')"
                                >
                            </validation>
                        </div>

                        <transition enter-active-class="collapsing" leave-active-class="collapsing" @enter="enter" @afterEnter="afterEnter" @leave="leave" @afterLeave="afterLeave">
                            <div class="o-form__set-accordion" v-if="show">
                                <div class="o-form__group">
                                    <validation
                                        :status-error="errors && errors.class"
                                        :input-name="inputNameMultiValue + `[${valueObj.id}][class]`"
                                    >
                                        <label :for="inputNameMultiValue + `[${valueObj.id}][class]`">Class</label>
                                        <input
                                            type="text"
                                            :id="inputNameMultiValue + `[${valueObj.id}][class]`"
                                            :name="inputNameMultiValue + `[${valueObj.id}][class]`"
                                            :value="valueObj.value && valueObj.value.class"
                                            v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'class')"
                                        >
                                    </validation>
                                </div>
                                <div class="o-form__group">
                                    <validation
                                        :status-error="errors && errors.id"
                                        :input-name="inputNameMultiValue + `[${valueObj.id}][id]`"
                                    >
                                        <label :for="inputNameMultiValue + `[${valueObj.id}][id]`">ID</label>
                                        <input
                                            type="text"
                                            :id="inputNameMultiValue + `[${valueObj.id}][id]`"
                                            :name="inputNameMultiValue + `[${valueObj.id}][id]`"
                                            :value="valueObj.value && valueObj.value.id"
                                            v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'id')"
                                        >
                                    </validation>
                                </div>
                                <div class="o-form__group">
                                    <validation
                                        :status-error="errors && errors.target"
                                        :input-name="inputNameMultiValue + `[${valueObj.id}][target]`"
                                    >
                                        <label :for="inputNameMultiValue + `[${valueObj.id}][target]`">Target</label>
                                        <input
                                            type="text"
                                            :id="inputNameMultiValue + `[${valueObj.id}][target]`"
                                            :name="inputNameMultiValue + `[${valueObj.id}][target]`"
                                            :value="valueObj.value && valueObj.value.target"
                                            v-on:keyup.stop="updateValue(valueObj, $event.target.value, 'target')"
                                        >
                                    </validation>
                                </div>
                            </div>
                        </transition>
                        <button class="o-btn o-btn--sm" @click="toggle($event)">{{ show ? 'less' : 'more' }} options</button>
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
            show: false,
            transitioning: false
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
        },
        toggle: function (evt) {
            evt.preventDefault()
            this.show = !this.show
        },
        enter: function (el) {
            el.style.height = 0
            el.offsetHeight
            el.style.height = el.scrollHeight + 'px'
            this.transitioning = true
        },
        afterEnter: function (el) {
            el.style.height = null
            this.transitioning = false
        },
        leave: function (el) {
            el.style.height = 'auto'
            el.style.display = 'block'
            const { height } = el.getBoundingClientRect()
            el.style.height = height + 'px'
            el.offsetHeight
            this.transitioning = true
            el.style.height = 0
        },
        afterLeave: function (el) {
            el.style.height = null
            this.transitioning = false
        }
    }
}
</script>
