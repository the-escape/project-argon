<template>
    <dialog class="c-edit">
        <header class="c-edit__header">
            <h3 class="c-edit__title">Image Details <span v-if="isEditing">- To be saved</span></h3>
        </header>
        <main class="c-edit__body">
            <div class="c-edit__preview">
                <div class="c-edit__image">
                    <img :src="url" :alt="name">
                </div>
                <div class="c-edit__replace-image">
                    <input type="file" hidden id="editImage" ref="editImageInput" @change="chooseNewImage">
                    <span>Overwrite existing asset?</span>
                    <label for="editImage" class="o-btn o-btn--xs">choose file</label>
                </div>
            </div>
            <div class="c-edit__details">
                <div class="o-form">
                    <div class="o-form__group">
                        <label for="name">File name</label>
                        <input type="text" id="name" v-model="name">
                    </div>
                </div>
                <dl>
                    <dt>File type:</dt>
                    <dd>{{ extension }}</dd>
                    <dt>Uploaded at:</dt>
                    <dd>{{ uploadedDate }}</dd>
                    <dt>Dimensions:</dt>
                    <dd>{{ dimensions }}</dd>
                    <dt>File Size:</dt>
                    <dd>{{ fileSize }}</dd>
                    <dt>Uploaded by:</dt>
                    <dd v-if="!isEditing">
                        <div class="c-edit__author">
                            <div class="c-edit__author-img" :style="{'background-image': `url(${authorImage})`}"></div>
                            <span>{{ authorName }}</span>
                        </div>
                    </dd>
                </dl>
            </div>
        </main>
        <footer class="c-edit__footer">
            <button class="o-btn o-btn--sm" @click="closeEdit">cancel</button>
            <button class="o-btn o-btn--sm o-btn--primary" @click="updateMediaItem">save</button>
        </footer>
    </dialog>
</template>

<script>
import { mapState } from 'vuex'

export default {
    computed: {
        ...mapState([
            'editItem'
        ])
    },
    data() {
        return {
            isEditing: false,
            name: '',
            url: '',
            extension: '',
            uploadedDate: '',
            dimensions: '',
            fileSize: '',
            authorName: '',
            authorImage: '/argon/images/user-icon.png'
        }
    },
    mounted(){
        this.resetCurrentItem()
    },
    methods: {
        resetCurrentItem() {
            const {
                extension,
                uploadedDate,
                filesize_formatted,
                authorName,
                authorImage
            } = this.editItem.item

            this.name = this.editItem.getName()
            this.url = this.editItem.getUrl()
            this.extension = extension
            this.uploadedDate = uploadedDate
            this.dimensions = this.editItem.getDimensions()
            this.fileSize = filesize_formatted
            this.authorName = authorName
            this.authorImage = authorImage
        },
        chooseNewImage() {

            if(!this.$refs.editImageInput.files.length){
                return
            }

            const file = this.$refs.editImageInput.files[0]

            if(!file.type.match('image.*')){
                return
            }

            const reader = new FileReader()
            reader.onload = readerEvt => {
                const image = new Image()
                image.src = readerEvt.target.result

                image.onload = imgEvt => {
                    this.isEditing = true
                    this.url = readerEvt.target.result
                    this.name = file.name
                    this.extension = file.name.split('.')[1]
                    this.uploadedDate = 'To be saved'
                    this.dimensions = `${imgEvt.target.width} x ${imgEvt.target.height}px`
                    this.fileSize = fileSize(file.size)
                }
            }
            reader.readAsDataURL(file)
        },
        closeEdit(){
            this.$store.dispatch('editItem')
        },
        updateMediaItem(){
            const data = {
                item: this.editItem,
                file: this.$refs.editImageInput.files[0],
                name: this.name.replace('.' + this.extension, '')
            }

            this.$store.dispatch('updateMediaItem', data)
            this.$refs.editImageInput.value = ''
            this.closeEdit()
        }
    }
}

function fileSize(bytes) {
    var exp = Math.log(bytes) / Math.log(1024) | 0;
    var result = (bytes / Math.pow(1024, exp)).toFixed(2);

    return result + ' ' + (exp == 0 ? 'bytes': 'KMGTPEZY'[exp - 1] + 'B');
}
</script>
