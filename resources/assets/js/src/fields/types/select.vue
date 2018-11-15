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
import Choices from 'choices.js'

export default {
    props: ['fieldId', 'comboId', 'comboItemId'],
    mixins: [FieldValues],
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
    computed: {
        options: function() {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            }else{
                field = this.$store.getters.getField(this.fieldId)
            }
            const options = field.options.settings.options
            return options.reduce((acc, opt) => {
                for(let key in opt){
                    acc.push({
                        value: key,
                        label: opt[key]
                    })
                }
                return acc
            }, [])
        },
        values: {
            get() {
                let field
                if(this.comboId){
                    const combo = this.$store.getters.getField(this.comboId)
                    const field = this.$store.getters.getComboField(this.comboId, this.fieldId)
                    if(combo && combo.values.length){
                        const values = combo.values.filter(value => value.id === this.comboItemId)

                        if(values.length && values[0][this.fieldId]){
                            if(combo.options.settings.multiple){
                                return values[0][this.fieldId]
                            }else if(values[0][this.fieldId][0]){
                                return values[0][this.fieldId][0]
                            }
                        }
                    }
                }else{
                    field = this.$store.getters.getField(this.fieldId)
                    if(field.options.settings.multiple){
                        return field.values.map(value => value.value)
                    }

                    if(field.values.length){
                        return field.values.map(value => value.value)[0]
                    }
                }

                return ''
            },
            set(values){
                if(!Array.isArray(values)){
                    values = [values]
                }

                const valueObjs = values.map((value, id) => {
                    return {
                        value,
                        id
                    }
                })

                if(this.comboId){
                    this.$store.commit('updateComboFieldValues', {
                        fieldID: this.fieldId,
                        comboID: this.comboId,
                        comboItemId: this.comboItemId,
                        newValues: valueObjs
                    })
                } else {
                    this.$store.commit('updateValues', {
                        fieldID: this.fieldId,
                        newValues: valueObjs
                    })
                }
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
