<template>
    <div class="m-details" v-if="editItem.isSet()">
        <h4 class="modal-title" id="myModalLabel">{{ editItem.getName() }}</h4>
        <div class="m-details__preview">
            <img :src="editItem.getUrl()" :alt="editItem.getName()">
        </div>
        <dl class="m-details__info">
            <dt>{{ editItem.getName() }}</dt>
            <dd><small>File type:</small> {{ editItem.item.extension }}</dd>
            <dd><small>Uploaded at:</small> {{ editItem.item.updated_at }}</dd>
            <dd><small>Dimensions:</small> {{ editItem.getDimensions() }}</dd>
            <dd><small>File Size:</small> {{ editItem.item.filesize }}</dd>
            <dd><small>Uploaded by:</small> {{ editItem.item.uploaded_by }}</dd>
        </dl>
        <button type="button" class="btn btn-default" @click="closeEdit">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
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
        }
    }
}
</script>
