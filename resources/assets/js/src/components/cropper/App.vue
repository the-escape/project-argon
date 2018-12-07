<template>
    <cropper-editor :image="image" v-if="image"></cropper-editor>
</template>

<script>
import Cropper from './components/Cropper.vue'

export default {
    components: {
        'cropper-editor': Cropper
    },
    data() {
        return {
            image: false
        }
    },
    mounted: function (){
        this.$root.$on('setImage', image => {
            this.image = image
        })
    },
    methods: {
        cropImage: function () {
            this.$root.$emit('cropImage', 'cropped image')
            this.image = false
        }
    }
}
</script>
