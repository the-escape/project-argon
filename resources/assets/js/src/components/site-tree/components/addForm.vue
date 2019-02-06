<template>
    <div class="o-table__dropdown is-active">
        <div class="o-table__dropdown-wrap">
            <div class="o-form">
                <div class="o-form__inline choices--page-list">
                    <label :for="'add' + inputName">Page Type</label>
                    <select :id="'add' + inputName">
                        <option v-for="(option, index) in options" :key="index" :value="option.id">{{ option.name }}</option>
                    </select>
                    <button class="o-btn o-btn--xs" @click="add($event)">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Choices from 'choices.js'

export default {
    props: ['inputName'],
    data() {
        return{
            options: [],
            selectedOption: null,
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
    created() {
        this.options = window.types
    },
    mounted: function () {
        const select = this.$el.querySelector('select')
        this.selectElement = select
        this.selectInstance = new Choices(select, this.choicesOptions)
        this.selectInstance.setValueByChoice(this.value)
        this.selectElement.addEventListener('change', this.selectChange.bind(this))
    },
    destroyed: function () {
        this.selectElement.removeEventListener('change', this.selectChange.bind(this))
    },
    methods: {
        selectChange () {
            this.selectedOption = this.selectInstance.getValue(true)
        },
        add (evt) {
            evt.preventDefault()
            this.$emit('add', this.selectedOption)
        }
    }
}
</script>

