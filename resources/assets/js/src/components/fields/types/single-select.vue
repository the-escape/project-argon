<template>
    <div class="o-form__group">
        <validation :status-error="errors" :input-name="inputName">
            <label :for="inputName">{{ name }}</label>
            <select :name="inputName" :id="inputName">
                <option value=" ">&nbsp;</option>
                <option v-for="(option, index) in options" :key="index" :value="option.value">{{ option.label }}</option>
            </select>
        </validation>
    </div>
</template>

<script>
import Validation from './util/validation.vue'
import FieldValues from './mixins/field-values.vue'
import SelectValues from './mixins/select-values.vue'
import Choices from 'choices.js'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues, SelectValues],
    components: {
        'validation': Validation
    },
    data(){
        return {
            selectInstance: null,
            selectElement: null,
            choicesOptions: {
                searchEnabled: false,
                searchChoices: false,
                paste: false,
                shouldSort: false,
                removeItemButton: true,
                placeholderValue: 'select',
                itemSelectText: '',
                callbackOnCreateTemplates: function (template) {
                    const classNames = this.config.classNames
                    return {
                        containerInner: () =>
                            template(`
                            <div class="${classNames.containerInner}">
                                <div class="choices__btn">
                                    <svg><use xlink:href="/argon/images/svgicons.svg#select"></use></svg>
                                </div>
                            </div>
                        `)
                    }
                }
            }
        }
    },
    watch: {
        values: function () {
            if(this.values === '') {
                this.selectInstance.highlightAll()
                this.selectInstance.removeHighlightedItems()
            }else{
                this.selectInstance.setValueByChoice(this.values)
            }
        }
    },
    methods: {
        selectChange: function (){
            this.values = this.selectInstance.getValue(true)
        }
    },
    mounted: function () {
        const select = this.$el.querySelector('select')
        this.selectElement = select
        this.selectInstance = new Choices(select, this.choicesOptions)
        this.selectInstance.setValueByChoice(this.values)
        this.selectElement.addEventListener('change', this.selectChange.bind(this))
    },
    destroyed: function () {
        this.selectElement.removeEventListener('change', this.selectChange.bind(this))
    }
}
</script>
