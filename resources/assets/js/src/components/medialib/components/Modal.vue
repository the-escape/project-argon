<template>
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
</template>

<script>
import { mapState } from 'vuex'

export default {
    computed: {
        ...mapState([
            'modal'
        ])
    }
}
</script>
