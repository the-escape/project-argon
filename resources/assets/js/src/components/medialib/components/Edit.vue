<template>
    <dialog class="c-edit">
        <header class="c-edit__header">
            <h3 class="c-edit__title">Image Details</h3>
        </header>
        <main class="c-edit__body">
            <div class="c-edit__preview">
                <div class="c-edit__image">
                    <img :src="editItem.getUrl()" :alt="editItem.getName()">
                </div>
                <div class="c-edit__replace-image">
                    <span>Overwrite existing asset?</span>
                    <input type="file" hidden id="editImage" ref="editImageInput" @change="updateImage($event)">
                    <label for="editImage" class="o-btn o-btn--xs">choose file</label>
                </div>
            </div>
            <div class="c-edit__details">
                <dl>
                    <dt>File Name:</dt>
                    <dd>{{ editItem.getName() }}</dd>
                    <!-- <dt>Location:</dt>
                    <dd></dd> -->
                    <dt>File type:</dt>
                    <dd>{{ editItem.item.extension }}</dd>
                    <dt>Uploaded at:</dt>
                    <dd>{{ editItem.item.uploadedDate }}</dd>
                    <dt>Dimensions:</dt>
                    <dd>{{ editItem.getDimensions() }}</dd>
                    <dt>File Size:</dt>
                    <dd>{{ editItem.item.filesize_formatted }}</dd>
                    <dt>Uploaded by:</dt>
                    <dd>
                        <div class="c-edit__author">
                            <div class="c-edit__author-img">
                                <img src="" alt="">
                            </div>
                            <span>{{ editItem.item.uploaded_by }}</span>
                        </div>
                    </dd>
                </dl>
            </div>
        </main>
        <footer class="c-edit__footer">
            <button class="o-btn o-btn--sm" @click="closeEdit">cancel</button>
            <button class="o-btn o-btn--sm o-btn--primary">save</button>
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
    methods: {
        closeEdit(){
            this.$store.dispatch('editItem')
        },
        updateImage(evt){
            if(!evt.target.files.length){
                return
            }

            this.$store.dispatch('updateMediaItem', {item: this.editItem, file: evt.target.files[0]})
            this.$refs.editImageInput.value = ''
        }
    }
}
</script>
