<template>
    <div class="media___modal modal fade" id="media-view">
        <div class="modal__table">
            <div class="modal__cell modal-dialog">
                <div class="modal-content">
                    <div class="media__modal-header">
                        <h1>DETAILS</h1>
                    </div>
                    <div class="media__modal-content">
                        <div class="media__modal-image">
                            <div class="media__modal-asset">
                                <img v-bind:src="activeItem.url" v-bind:alt="activeItem.filename">
                            </div>
                        </div>
                        <div class="media__modal-details">
                            <div class="form__group">
                                <label for="name">Filename</label>
                                <input id="name" name="name" class="form__text"
                                       v-bind:value="activeItem.filename">
                            </div>
                            <ul>
                                <li><span>File type:</span> {{ activeItem.extension }}</li>
                                <li><span>Uploaded on:</span> {{ activeItem.uploadedAt }}</li>
                                <li><span>File size:</span> {{ activeItem.filesize }}</li>
                                <li v-if="activeItem.width && activeItem.height"><span>Dimensions:</span> {{ activeItem.width }}px x {{ activeItem.height }}px</li>
                                <li><span>Uploaded by:</span> {{ activeItem.uploadedBy }}</li>
                            </ul>
                            <div class="modal__modal-buttons">
                                <button type="submit" class="form__btn">SAVE</button>
                                <button class="form__btn form__btn--grey" data-dismiss="modal">CANCEL</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        computed: mapGetters({
            activeItem: 'activeItem'
        })
    }
</script>
