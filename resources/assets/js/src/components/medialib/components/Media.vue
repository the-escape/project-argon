<template>
    <div class="mlapp">

        <div class="ml">

            <div class="ml__options o-form l-flexcols">

                <div class="ml__options-layout l-flexcols-1">

                    <div class="layout ">
                        <button type="button" class="o-btn o-btn--xs" :class="{ 'o-btn--active':layout==='tiles'}" v-on:click="setLayout('tiles')">Tiles</button>
                        <button type="button" class="o-btn o-btn--xs" :class="{'o-btn--active':layout==='list'}" v-on:click="setLayout('list')">List</button>
                    </div>

                </div>

                <div class="l-flexcols-2">

                    <div class="search" :class="{'search--loading':search.isLoading()}">

                        <div class="search__inp">
                            <input type="text" class="inp" placeholder="Search for..." v-model="keywords">
                        </div>

                        <div class="search__btn">
                            <button class="o-btn o-btn--xs" type="button" v-on:click="searchReset()">Clear</button>
                        </div>

                    </div>

                </div>

            </div>

            <div class="ml__view l-flexcols">

                <div class="ml__tree l-flexcols-1">

                    <div class="ml__heading">
                        Folders Tree
                    </div>

                    <div class="ml__body">
                        <DirectoryTree/>
                    </div>

                </div>

                <div class="ml__preview l-flexcols-2">


                    <template v-if="search.hasKeywords()">

                        <div class="ml__heading">
                            Found {{ search.getResultsCount() }} results for `{{ search.keywords }}`
                        </div>

                        <div class="ml__body">

                            <div class="search-results" v-if="search.hasResults()">
                                <Content v-bind:items="search.getResults()" v-bind:folders="{}"/>
                            </div>

                            <div class="search-results" v-else>
                                <p>No results found.</p>
                            </div>

                        </div>

                    </template>

                    <template v-else>

                        <div class="ml__heading">

                            <div class="breadcrumbs" v-if="active.isSet()" >

                                <span class="btn-skip o-btn" v-bind:class="{'o-btn--disabled': !back.isSet()}" v-on:click="folderSelected(back)" title="Skip between current and previous folder">&#x21C4;</span>

                                <template v-for="folder of active.breadcrumbs()">
                                    <span class="breadcrumbs__separator" v-if="folder.parent">&gt;</span>

                                    <span class="breadcrumbs__piece" v-bind:class="{'breadcrumbs__child': folder.parent}" v-on:click="folderSelected(folder)">
                                        {{ folder.name }}
                                    </span>
                                </template>

                            </div>

                        </div>

                        <div class="ml__body">

                            <div class="folder__act">
                                <button class="o-btn o-btn--xs" @click="createFolder(active)">Add folder</button>
                                <button class="o-btn o-btn--xs" v-if="!active.isRoot()" @click="editFolder(active)">Edit folder</button>
                                <button class="o-btn o-btn--xs" v-if="!active.isRoot()" @click="removeFolder(active)">Remove folder</button>
                                <button class="o-btn o-btn--xs" @click="onUploadClick">{{ upload.getLabel() }}</button>

                                <div v-if="upload.isInitialised()" class="ml-upload">

                                    <div class="ml-upload__field">
                                        <input type="file" multiple accept="*/*" @change="onFileSelected" ref="fileInput" style="display: none">
                                        <button class="o-btn o-btn--xs" @click="$refs.fileInput.click()">Select file(s)</button>
                                        <button class="o-btn o-btn--xs" v-if="upload.hasFiles()" @click="onUpload()">Upload</button>
                                    </div>

                                    <div v-if="upload.hasFiles()" class="ml-upload__output">
                                        <ul>
                                            <li v-for="u of upload.getFiles()">{{ u.name }}</li>
                                        </ul>
                                    </div>

                                </div>

                            </div>

                            <Folder/>

                        </div>

                    </template>

                </div>
            </div>

        </div>

        <div class="m-details modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" v-if="modal.isSet()">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ modal.getName() }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="m-details__content">
                            <div class="m-details__preview">
                                <img :src="modal.getUrl()" :alt="modal.getName()">
                            </div>
                            <dl class="m-details__info">
                                <dt>{{ modal.getName() }}</dt>
                                <dd><small>File type:</small> {{ modal.item.extension }}</dd>
                                <dd><small>Uploaded at:</small> {{ modal.item.updated_at }}</dd>
                                <dd><small>Dimensions:</small> {{ modal.getDimensions() }}</dd>
                                <dd><small>File Size:</small> {{ modal.item.filesize }}</dd>
                                <dd><small>Uploaded by:</small> {{ modal.item.uploaded_by }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import  { mapState } from 'vuex'
    import DirectoryTree from './DirectoryTree.vue'
    import Folder from "./Folder.vue"
    import Content from "./Content.vue"
    import debounce from "lodash/debounce"

    export default {
        created () {
            this.$store.dispatch('loadLibrary');
        },
        data () {
            return {}
        },
        watch: {
            keywords: function () {
                this.searchItems()
            }
        },
        computed: {
            ...mapState([
                'active',
                'back',
                'search',
                'modal',
                'layout',
                'upload'
            ]),
            keywords: {
                set(keywords) {
                    this.$store.dispatch('search', keywords)
                },
                get() {
                    return this.search.keywords
                }
            }
        },
        components: {
            Content,
            Folder,
            DirectoryTree
        },
        methods: {
            searchReset() {
                this.search.reset()
            },
            searchItems: debounce(function () {
                this.$store.dispatch('search', this.keywords)
            }, 700),
            folderSelected(folder) {
                this.$store.dispatch('folderSelected', folder)
            },
            setLayout(layout) {
                this.$store.dispatch('setLayout', layout)
            },
            createFolder(parent) {
                let fn = prompt("Please enter the folder name:", "New Folder")
                if (fn) {
                    let payload = {name: fn, parent: parent}
                    this.$store.dispatch('createFolder', payload)
                }
            },
            editFolder(folder) {
                let fn = prompt("Please edit the folder name:", folder.name)
                if (fn) {
                    let payload = {name: fn, folder: folder}
                    this.$store.dispatch('editFolder', payload)
                }

            },
            removeFolder(active) {
                let c = confirm("Are you sure?")
                if (c === true) {
                    this.$store.dispatch('removeFolder', active)
                }
            },
            onFileSelected(e) {
                this.upload.files = e.target.files
            },
            onUpload() {
                if (!this.upload.hasFiles()) {
                    return alert("Nothing to upload.\nPlease select files to upload and continue...")
                }

                let fd = new FormData()
                fd.append('folder', this.active.id)

                Array
                    .from(Array(this.upload.getFiles().length).keys())
                    .map(x => {
                        fd.append('files[]', this.upload.files[x], this.upload.files[x].name);
                    })

                this.$store.dispatch('uploadItems', fd)
            },
            onUploadClick() {
                if (this.upload.isInitialised()) {
                    return this.upload.reset()
                }

                return this.upload.init()
            }
        }
    }
</script>
