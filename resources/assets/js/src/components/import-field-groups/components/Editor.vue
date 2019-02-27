<template>
    <div>
        <div class="json-editor-wrapper c-json-editor" :class="{ 'expanded': isEditorExpanded }">
            <div class="loading-overlay c-json-editor__loading-overlay js-loading-block" :class="{ 'show': isLoading }"></div>
            <div class="editor-tools c-json-editor__editor-tools">
                <span class="settings fa fa-cog" @click="expandConfig"></span>
                <span class="expand fa fa-expand" @click="expandEditor(true)"></span>
                <span class="collapse fa fa-compress" @click="expandEditor(false)"></span>
            </div>

            <div class="c-library-tools library-tools js-library-tools" :class="{ 'show': selectedBlock }">
                <span class="c-library-tools__button c-library-tools__create create fa fa-plus" @click="createNewBlock"></span>

                <span class="c-library-tools__button c-library-tools__save save fa fa-save" @click="saveBlock"></span>

                <span class="c-library-tools__button c-library-tools__input"><input type="text" placeholder="Block name" name="lib_block_name" :value="selectedBlock && selectedBlock.name" @keyup="updateName($event)"></span>

                <template v-if="selectedBlock && selectedBlock.image">
                    <label class="js-select-image selected" @click.prevent="unselectImage">
                        <span class="c-library-tools__button c-library-tools__image image fa fa-image"></span>
                        <input type="file" name="lib_block_image_tmp" style="display:none;">
                        <input type="hidden" name="lib_block_image" :value="selectedBlock && selectedBlock.image">
                    </label>
                </template>
                <template v-else>
                    <label class="js-select-image">
                        <span class="c-library-tools__button c-library-tools__image image fa fa-image"></span>
                        <input type="file" name="lib_block_image_tmp" style="display:none;" @change="selectImage($event)">
                        <input type="hidden" name="lib_block_image" value="">
                    </label>
                </template>



                <span class="c-library-tools__button c-library-tools__toggle toggle toggle-json" :class="{ 'active': editorMode === 'json' }" @click="changeMode('json')">json</span>
                <span class="c-library-tools__button c-library-tools__toggle toggle toggle-blade" :class="{ 'active': editorMode === 'blade' }" @click="changeMode('blade')">blade</span>
                <span class="c-library-tools__button c-library-tools__toggle toggle toggle-mappers" :class="{ 'active': editorMode === 'mappers' }" @click="changeMode('mappers')">php</span>

                <template v-if="selectedBlock && selectedBlock.id">
                    <span class="c-library-tools__button c-library-tools__delete delete fa fa-trash" @click="deleteBlock"></span>
                </template>

                <span class="c-library-tools__button c-library-tools__close  js-library-close-block fa fa-close" @click="unselectBlock"></span>
            </div>

            <textarea class="form-control hidden js-block-lib-data" id="json-textarea" name="json">{{ contentJson }}</textarea>
            <textarea class="form-control hidden js-block-lib-data" id="blade-textarea" name="blade">{{ contentBlade }}</textarea>
            <textarea class="form-control hidden js-block-lib-data" id="mappers-textarea" name="mappers">{{ contentMappers }}</textarea>
            <div id="json-editor" class="c-json-editor__editor"></div>

        </div>

        <div class="c-blocks-library__settings-wrapper js-settings-wrapper" :class="{ 'expanded': isConfigExpanded }">
            <div class="typography l-space">
                <h3>Import settings</h3>
            </div>
            <div class="o-form__group">
                <div class="o-form-status">
                    <div class="o-form__list">
                        <div class="o-checkbox" @click.stop="toggleSmartImport($event)">
                            <input type="hidden" name="smart_import" class="js-toggle-value" value="0">
                            <label>
                                <input type="checkbox" value="1" name="" id="smart_import" class="js-toggle-input" :checked="smartImport">
                                <span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span>
                            </label>
                            <label for="smart_import">Smart Import</label>
                        </div>
                    </div>
                </div>
                <div class="o-form__help-text l-full">
                    <p>If the fields already exist append number at the end of the field name and carry on with the import</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        name: 'Editor',
        data() {
            return {
                editor: null,
                modes: {},
            }
        },
        mounted() {
            this.editor = ace.edit("json-editor")
            this.editor.setTheme("ace/theme/twilight")
            this.modes.json = ace.require("ace/mode/json").Mode
            this.modes.php = ace.require("ace/mode/php").Mode
            this.editor.getSession().on('change', this.changeContent)
            this.changeMode('json')
            this.setSmartImport(window.smartImport)
        },
        methods: {
            setMode: function() {
                if (this.editorMode === 'mappers') {
                    this.editor.session.setMode(new this.modes.php())
                    this.editor.getSession().setValue(this.editorContent.mappers)
                } else if (this.editorMode === 'blade') {
                    this.editor.session.setMode(new this.modes.php())
                    this.editor.getSession().setValue(this.editorContent.blade)
                } else {
                    this.editor.session.setMode(new this.modes.json())
                    this.editor.getSession().setValue(this.editorContent.json)
                }
            },
            setSmartImport: function(value) {
                this.$store.commit('setSmartImport', value)
            },
            toggleSmartImport: function(event) {
                if(!event.target.classList.contains('js-toggle-input')){
                    return
                }

                const value = event.target.checked

                this.$store.commit('setSmartImport', value)
            },
            changeMode: function(mode) {
                this.$store.commit('changeEditorMode', mode)
            },
            changeContent: function() {
                const newContent = this.editor.getSession().getValue()
                switch(this.editorMode){
                    case 'blade':
                        this.$store.commit('setContentBlade', newContent)
                        break;
                    case 'mappers':
                        this.$store.commit('setContentMappers', newContent)
                        break;
                    case 'json':
                    default:
                        this.$store.commit('setContentJson', newContent)
                        break;
                }
            },
            expandEditor: function(bool) {
                this.$store.commit('expandEditor', bool)
                setTimeout(() => this.editor.resize(), 100)
            },
            expandConfig: function(bool) {
                this.$store.commit('expandConfig', !this.isConfigExpanded)
            },
            updateName: function(evt) {
                this.$store.commit('setBlockName', evt.target.value)
            },
            createNewBlock: function() {
                this.$store.commit('createNewBlock')
            },
            saveBlock: function() {
                this.$store.commit('saveBlockToLibrary')
            },
            deleteBlock: function() {
                this.$store.commit('deleteBlockFromLibrary')
            },
            unselectBlock: function() {
                this.changeMode('json')
                this.$store.commit('setSelectedBlock', null)
            },
            unselectImage: function() {
                this.$store.commit('setBlockImage', '')
            },
            selectImage: function(evt) {
                const file = evt.target.files[0]
                const reader = new FileReader()
                reader.onloadend = () => {
                    this.$store.commit('setBlockImage', reader.result)
                }
                reader.readAsDataURL(file)
            }
        },
        watch: {
            editorContent: function() {
                this.setMode()
            },
            editorMode: function() {
                this.setMode()
            }
        },
        computed: {
            ...mapState({
                editorMode: 'editorMode',
                editorContent: 'content',
                selectedBlock: 'block',
                isLoading: 'isLoading',
                isEditorExpanded: 'isEditorExpanded',
                isConfigExpanded: 'isConfigExpanded',
                smartImport: 'smartImport'
            }),
            contentJson: function() {
                return this.$store.state.content.json
            },
            contentBlade: function() {
                return this.$store.state.content.blade
            },
            contentMappers: function() {
                return this.$store.state.content.mappers
            }
        }
    }
</script>

