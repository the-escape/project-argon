<template>
    <textarea :id="inputName" :name="inputName" :style="{ height: totalHeight + 'px' }"></textarea>
</template>

<script>
import { EventBus } from './util/bus'

export default {
    props: ['fieldId', 'comboId', 'comboItemId', 'name', 'valueObj'],
    data () {
        return {
            textareaElement: null,
            wysiwygInstance: null,
            totalHeight: 150,
            defaultConfig: {
                language: 'en-gb',
                customConfig: '',
                filebrowserBrowseUrl: '/admin/media/modal/all',
                toolbar: [
                    [
                        'Format',
                        'Styles',
                        'TextColor',
                        '-',
                        'Bold',
                        'Italic',
                        'RemoveFormat',
                        '-',
                        'NumberedList',
                        'BulletedList',
                        '-',
                        'Link',
                        'Unlink',
                        '-',
                        'JustifyLeft',
                        'JustifyCenter',
                        'JustifyRight',
                        '-',
                        'Image',
                        'Blockquote',
                        '-',
                        'Source',
                        'Maximize'
                    ]
                ],
                height: 150,
                format_tags: 'p;h1;h2;h3;h4',
                extraAllowedContent: 'iframe[*]',
                colorButton_colors: '',
                colorButton_enableAutomatic: false,
                colorButton_enableMore: false,
                contentCss: '', // iframe styles
                stylesSet: [],
                extraPlugins: 'stylesheetparser',
                forcePasteAsPlainText: true,
                pasteFromWordRemoveStyles: true,
                pasteFromWordRemoveFontStyles: true,
                removePlugins: 'pastefromword'
            }
        }
    },
    watch: {
        valueObj: function () {
            CKEDITOR.instances[this.wysiwygInstance].setData(this.valueObj.value)
        }
    },
    computed: {
        config: function () {
            let field
            if(this.comboId){
                field = this.$store.getters.getComboField(this.comboId, this.fieldId)
            }else{
                field = this.$store.getters.getField(this.fieldId)
            }
            const fieldConfig = field.options.settings['editor_options']

            let config = {}

            if(fieldConfig['format-tags']){
                config.format_tags = 'p;' + fieldConfig['format-tags']
            }

            if(fieldConfig['height']){
                config.height = fieldConfig['height']
            }

            if(fieldConfig['toolbar']){
                config.toolbar = [fieldConfig['toolbar'].split(',')]
            }

            if(fieldConfig['extra-allowed-content']){
                config.extraAllowedContent = fieldConfig['extra-allowed-content']
            }

            if(fieldConfig['typography-styles']){
                config.contentsCss = fieldConfig['typography-styles']
            }

            config = Object.assign({}, this.defaultConfig, config)
            return config
        },
        inputName: function () {
            return this.name
        }
    },
    methods: {
        updateValue: function(newValue) {
            this.$emit('update', newValue)
        }
    },
    mounted: function () {
        let name = 'move-' + this.fieldId
        if(this.comboId){
            name = 'move-' + this.fieldId + '-' + this.comboId + '-' + this.comboItemId
        }
        EventBus.$on(name, () => {
            updateEditorHeight.call(this)
            destoryEditor.call(this)
            mountEditor.call(this)
        })

        mountEditor.call(this)
    },
    beforeDestroy: function () {
        destoryEditor.call(this)
    }
}

function updateEditorHeight(){
    this.totalHeight = this.textareaElement.nextElementSibling.offsetHeight
}

// TODO: fix multi wysiwyg instances, as it appears as a single ckeditor instance and adding a unique hash to the name breaks the backend
function mountEditor () {
    const textarea = this.$el
    this.textareaElement = textarea

    CKEDITOR.replace(this.textareaElement, this.config)
    this.wysiwygInstance = this.textareaElement.name
    CKEDITOR.instances[this.wysiwygInstance].setData(this.valueObj.value)
    this.$el.value = this.valueObj.value
    CKEDITOR.instances[this.wysiwygInstance].on('change', () => {
        const data = CKEDITOR.instances[this.wysiwygInstance].getData()
        this.updateValue(data)
        this.$el.value = data
    })
}

function destoryEditor () {
    CKEDITOR.instances[this.wysiwygInstance] && CKEDITOR.instances[this.wysiwygInstance].destroy(true)
}
</script>

