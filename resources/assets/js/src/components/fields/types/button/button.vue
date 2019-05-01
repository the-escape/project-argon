<template>
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
                        v-model="label"
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
                        v-model="url"
                    >
                </validation>
            </div>

            <input
                type="hidden"
                :name="inputNameMultiValue + `[${valueObj.id}][class]`"
                v-model="btnclass"
            >
            <input
                type="hidden"
                :name="inputNameMultiValue + `[${valueObj.id}][id]`"
                v-model="id"
            >
            <input
                type="hidden"
                :name="inputNameMultiValue + `[${valueObj.id}][target]`"
                v-model="target"
            >

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
                                v-model="btnclass"
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
                                v-model="id"
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
                                v-model="target"
                            >
                        </validation>
                    </div>
                </div>
            </transition>
            <button class="o-btn o-btn--sm" @click="toggle($event)">{{ show ? 'less' : 'more' }} options</button>
        </div>
    </div>
</template>

<script>
import InputIcon from '../util/input-icon.vue'
import Validation from '../util/validation.vue'
import FieldValues from '../mixins/field-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
    components: {
        'input-icon': InputIcon,
        'validation': Validation,
    },
    mixins: [FieldValues],
    data() {
        return {
            show: false,
            transitioning: false,
            loading: true,
            label: '',
            url: '',
            btnclass: '',
            id: '',
            target: ''
        }
    },
    mounted() {
        if(this.valueObj.value){
            this.label = this.valueObj.value.label
            this.url = this.valueObj.value.url
            this.btnclass = this.valueObj.value.class
            this.id = this.valueObj.value.id
            this.target = this.valueObj.value.target
        }
        this.loading = false
    },
    watch: {
        label: function (newValue) {
            if(this.loading){
                return
            }
            this.updateValue(newValue, 'label')
        },
        url: function (newValue) {
            if(this.loading){
                return
            }
            this.updateValue(newValue, 'url')
        },
        btnclass: function (newValue) {
            if(this.loading){
                return
            }
            this.updateValue(newValue, 'class')
        },
        id: function (newValue) {
            if(this.loading){
                return
            }
            this.updateValue(newValue, 'id')
        },
        target: function (newValue) {
            if(this.loading){
                return
            }
            this.updateValue(newValue, 'target')
        }
    },
    methods: {
        updateValue: function(newValue, prop) {
            if(!this.valueObj.value){
                this.valueObj.value = {}
            }
            this.valueObj.value[prop] = newValue

            this.$nextTick(() => {
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
            })
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
