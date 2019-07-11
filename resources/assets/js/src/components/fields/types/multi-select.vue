<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName">{{ name }}</label>
            <div class="o-drag-select js-drag">
                <input type="hidden" v-for="(option, index) in valueOptions" :key="index" :name="inputName" :value="option.value">
                <div class="o-drag-select__column-wrap">
                    <div class="o-drag-select__title">
                        <div class="o-drag-select__search">
                            <input type="text" v-model="search" placeholder="Search..">
                            <button class="o-drag-select__search-close" @click.prevent="clearSearch"></button>
                        </div>
                    </div>
                    <draggable class="o-drag-select__column o-drag-select__column--inactive" v-model="filteredOptions" :options="{ group: { name: 'multiselect-' + inputName, pull:true, put:true }, animation: 75 }">
                        <div class="o-drag-select__item" v-for="option in filteredOptions" :key="option.value">
                            <div class="o-drag-select__item-wrap">
                                <span>{{option.label}}</span>
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#move"></use>
                                </svg>
                            </div>
                        </div>
                    </draggable>
                </div>
                <div class="o-drag-select__arrow">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#arrow-right"></use>
                    </svg>
                </div>
                <div class="o-drag-select__column-wrap">
                    <div class="o-drag-select__title"><span>Selected</span></div>
                    <draggable class="o-drag-select__column o-drag-select__column--active" v-model="valueOptions" :options="{ group: { name: 'multiselect-' + inputName, pull:true, put:true }, animation: 75 }">
                        <div class="o-drag-select__item" v-for="option in valueOptions" :key="option.value">
                            <div class="o-drag-select__item-wrap">
                                <span>{{option.label}}</span>
                                <svg>
                                    <use xlink:href="/argon/images/svgicons.svg#move"></use>
                                </svg>
                            </div>
                        </div>
                    </draggable>
                </div>
            </div>
        </validation>
    </div>
</template>

<script>
import FieldValues from './mixins/field-values.vue'
import Validation from './util/validation.vue'
import SelectValues from './mixins/select-values.vue'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues, SelectValues],
    components: {
        'validation': Validation
    },
    data() {
        return {
            search: '',
            tmpFiltered: [],
            tmpValues: []
        }
    },
    watch:{
        values: function(){
            this.filterOptions()
        }
    },
    created: function () {
        this.filterOptions()
    },
    computed: {
        filteredOptions: {
            get () {
                if(this.search){
                    return this.tmpFiltered.filter(el => el.label.match(new RegExp(this.search)))
                }
                return this.tmpFiltered
            },
            set (values) {
                this.tmpFiltered = values
            }
        },
        valueOptions: {
            get () {
                return this.tmpValues
            },
            set (values) {
                this.tmpValues = values
                this.values = this.tmpValues.map(value => value.value)
            }
        }
    },
    methods: {
        filterOptions () {
            this.tmpFiltered = this.options.filter(option => !~this.values.findIndex(value => value === option.value))
            this.tmpValues = this.values.reduce((acc, value) => {
                if(!value){
                    return acc
                }

                const option = this.options.find(opt => opt.value === value)
                if(!option){
                    return acc
                }

                acc.push(option)
                return acc
            }, [])
        },
        clearSearch (){
            this.search = ''
        }
    }
}
</script>

