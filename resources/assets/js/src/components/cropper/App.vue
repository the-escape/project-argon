<template>
    <cropper-editor :image="image" :use-rotator="useRotator" :ratio="ratio" v-if="image" @crop="cropImage"></cropper-editor>
</template>

<script>
import Cropper from './components/Cropper.vue'
import Noty from 'noty'

export default {
    components: {
        'cropper-editor': Cropper
    },
    data() {
        return {
            image: false,
            useRotator: true,
            ratio: false
        }
    },
    mounted: function (){
        this.$root.$on('setOptions', options => {
            if(!options.hasOwnProperty('image')){
                new Noty({
                    layout: 'topCenter',
                    text: 'No Image was passed to the cropper!',
                    type: 'error',
                    timeout: 3500
                }).show()
                return
            }

            this.image = options.image

            if(options.hasOwnProperty('rotator')){
                this.useRotator = options.rotator
            }

            if(options.hasOwnProperty('ratio')){
                this.ratio = options.ratio
            }
        })
    },
    methods: {
        cropImage: function (croppedImage) {
            this.$root.$emit('cropImage', croppedImage)
            this.image = false
        }
    }
}
</script>
