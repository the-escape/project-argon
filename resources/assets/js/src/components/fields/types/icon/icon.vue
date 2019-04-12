<template>
    <div class="o-item-picker o-item-picker--no-edit o-item-picker--label" :class="{'is-open': pickerOpen}">
        <button class="o-item-picker__btn" @click.prevent="togglePicker">
            <svg>
                <use :xlink:href="svgPath + value.value"></use>
            </svg>
        </button>
        <input type="hidden" :name="inputName" :id="inputName" v-model="value.value">
        <output class="o-item-picker__output" @click.prevent="launchPicker">{{ value.name }}</output>
        <button class="o-item-picker__dropdown-btn" @click.prevent="togglePicker">
            <svg><use xlink:href="/argon/images/svgicons.svg#select"></use></svg>
        </button>

        <div class="o-item-picker__window" >
            <button class="o-item-picker__close" @click.prevent="closePicker"></button>
            <div class="o-item-picker__vignette"></div>
            <div class="o-item-picker__list">
                <div class="o-item-picker__search">
                    <input type="text" v-model="search" placeholder="search...">
                    <button class="o-item-picker__search-close" @click.prevent="clearSearch"></button>
                </div>
                <button class="o-item-picker__item" v-for="(option, index) in filteredOptions" :key="index" @click.prevent="setValue(option)">
                    <div class="o-item-picker__icon">
                        <svg>
                            <use :xlink:href="svgPath + option.value"></use>
                        </svg>
                    </div>
                    <span class=o-item-picker__label>{{ option.name }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import FieldValues from '../mixins/field-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId', 'valueObj'],
    mixins: [FieldValues],
    data() {
        return {
            search: '',
            value: {name: '', value: ''},
            pickerOpen: false,
            svgPath: '/images/svgicons.svg#',
            options: []
        }
    },
    created() {
        this.options = []
        if(this.field.options.settings.svg_pat){
            this.svgPath = this.field.options.settings.svg_path + '#'
        }

        if(this.field.options.settings.meta_path){
            fetch(this.field.options.settings.meta_path)
                .then(res => res.json())
                .then(({svgicons}) => {
                    this.options = svgicons.map(el => {
                        return {
                            name: el,
                            value: el
                        }
                    })
                    this.$emit('optionsSet')
                })
        }
    },
    mounted() {
        this.loading = false
        this.$on('optionsSet', () => {
            this.value = this.options.find(option => option.value === this.valueObj.value) || this.value
        })
    },
    computed: {
        filteredOptions: function () {
            if(this.search){
                return this.options.filter(el => el.name.match(new RegExp(this.search)))
            }
            return this.options
        }
    },
    methods: {
        updateValue: function() {
            this.valueObj.value = this.value.value

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
        },
        launchPicker: function () {
            this.pickerOpen = true
        },
        closePicker: function () {
            this.pickerOpen = false
        },
        togglePicker: function () {
            this.pickerOpen = !this.pickerOpen
        },
        setValue: function (newValue) {
            this.value = newValue
            this.updateValue()
            this.closePicker()
        },
        clearSearch: function (){
            this.search = ''
        }
    }
}
</script>
