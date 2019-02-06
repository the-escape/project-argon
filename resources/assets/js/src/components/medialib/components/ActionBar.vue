<template>
    <div class="c-media-library__header">
        <div class="c-media-library__button-group">
            <button class="c-media-library__btn" back>
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#arrow-left"></use>
                </svg>
            </button>
            <button class="c-media-library__btn" forward>
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#arrow-right"></use>
                </svg>
            </button>
        </div>

        <div class="c-media-library__button-group">
            <button class="c-media-library__btn" :class="{ 'is-active': layout === 'tiles' }" @click="setLayout('tiles')">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#blocks"></use>
                </svg>
            </button>
            <button class="c-media-library__btn" :class="{ 'is-active': layout === 'list' }" @click="setLayout('list')">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#list"></use>
                </svg>
            </button>
            <div class="c-media-library__search" :class="{ 'hide-icon': keywords.length || isSearchFocussed }">
                <input type="text" v-model="keywords" @focus="setSearchFocus(true)" @blur="setSearchFocus(false)">
                <div class="c-media-library__search-icon">
                    <svg>
                        <use xlink:href="/argon/images/svgicons.svg#search"></use>
                    </svg>
                </div>
            </div>
        </div>

        <div class="c-media-library__button-group">
            <button class="o-btn o-btn--sm" @click="createFolder(active)">Add folder</button>
            <button class="o-btn o-btn--primary o-btn--sm">upload media</button>
        </div>

        <!-- searchReset() ?? -->

        <!-- <div class="folder__act" hidden>
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
        </div> -->
    </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
    data() {
        return {
            isSearchFocussed: false
        }
    },
    computed: {
        ...mapState(['layout', 'search', 'active', 'upload']),
        keywords: {
            set(keywords) {
                if(!keywords.length){
                    this.search.reset()
                }else{
                    this.$store.dispatch('search', keywords)
                }
            },
            get() {
                return this.search.keywords
            }
        }
    },
    methods: {
        setSearchFocus(isFocused = true) {
            this.isSearchFocussed = isFocused
        },
        setLayout(layout) {
            this.$store.dispatch('setLayout', layout)
        },
        searchReset() {
            this.search.reset()
        },
        searchItems: function () {
            this.$store.dispatch('search', this.keywords)
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

