<template>
    <div class="o-table__dropdown is-active" :class="{'c-menu-edit__add-wrap': !node}">
        <div class="c-menu-edit__tree-gap" v-if="!node"></div>
        <div class="o-table__dropdown-wrap">
            <div class="o-form c-menu-edit__form">
                <div class="l-halves">
                    <div>
                        <div class="o-form__group">
                            <label for="label">Label</label>
                            <input v-model="item.label" type="text" id="label" placeholder="Label">
                        </div>
                        <div class="o-form__group">
                            <label for="page">Page</label>
                            <select id="page">
                                <option value="0">-- select page or add custom URL below --</option>
                                <option v-for="(option, index) in options" :key="index" :value="index" :selected="item.page == index">{{ option }}</option>
                            </select>
                        </div>
                        <div class="o-form__group" v-if="!+this.item.page">
                            <label for="url">URL</label>
                            <input v-model="item.url" type="text" id="url" placeholder="URL">
                        </div>

                    </div>
                    <div>
                        <div class="o-form__group">
                            <label for="class">Class(es)</label>
                            <input v-model="item.class" type="text" id="class" placeholder="Class(es)">
                        </div>
                        <div class="o-form__group">
                            <label for="id">ID</label>
                            <input v-model="item.id" type="text" id="id" placeholder="ID">
                        </div>
                        <div class="o-form__group">
                            <label for="target">Target</label>
                            <input v-model="item.target" type="text" id="target" placeholder="Target">
                        </div>
                    </div>
                </div>
                <div class="choices--page-list">
                    <button class="o-btn o-btn--xs" @click="add($event)" :class="{'o-btn--primary': itemChanged}" v-if="!node">Add child</button>
                    <button class="o-btn o-btn--xs" @click="edit($event)" :class="{'o-btn--primary': itemChanged}" v-if="node">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Choices from 'choices.js'

export default {
    props: ['node'],
    data() {
        return{
            item: {
                label: '',
                page: '0',
                url: '',
                class: '',
                id: '',
                target: ''
            },
            initialItem: {},
            options: [],
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
        this.options = window.pagesJson

        this.setInitialItem()
    },
    mounted() {
        const select = this.$el.querySelector('select')
        this.selectElement = select
        this.selectInstance = new Choices(select, this.choicesOptions)
        this.selectInstance.setValueByChoice(this.value)
        this.selectElement.addEventListener('change', this.selectChange.bind(this))
        this.selectedOption = this.selectInstance.getValue(true)

        this.setInitialItem()
    },
    destroyed() {
        this.selectElement.removeEventListener('change', this.selectChange.bind(this))
    },
    methods: {
        selectChange () {
            this.item.page = this.selectInstance.getValue(true)
        },
        edit (evt) {
            evt.preventDefault()
            this.$emit('edit', this.item)
        },
        add (evt) {
            evt.preventDefault()
            this.$emit('add', this.item)
        },
        setInitialItem () {
            if (this.node) {
                this.item = this.node.data
            } else {
                this.item = {
                    label: '',
                    page: '0',
                    url: '',
                    class: '',
                    id: '',
                    target: ''
                }
            }

            this.initialItem = JSON.parse(JSON.stringify(this.item))
        }
    },
    watch: {
        node: function () {
            // this.setInitialItem()
        }
    },
    computed: {
        itemChanged: function() {
            return JSON.stringify(this.item) != JSON.stringify(this.initialItem)
        }
    }
}

</script>

