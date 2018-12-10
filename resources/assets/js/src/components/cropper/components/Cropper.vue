<template>
    <div class="c-cropper">
        <div class="c-cropper__container">
            <img ref="img" :src="image.path" />
            <div class="c-cropper__toolbar">
                <div class="c-cropper__toolbar-left">
                    <button class="c-cropper__btn" @click="dragImage($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#move" /></svg>
                        </div>
                    </button>
                    <button class="c-cropper__btn" @click="dragCrop($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#crop" /></svg>
                        </div>
                    </button>
                    <button class="c-cropper__btn" @click="zoomIn($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#zoom-in" /></svg>
                        </div>
                    </button>
                    <button class="c-cropper__btn" @click="zoomOut($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#zoom-out" /></svg>
                        </div>
                    </button>
                </div>
                <div class="c-cropper__toolbar-mid" v-if="useRotator">
                    <rotater-input v-model="rotation"></rotater-input>
                </div>
                <div class="c-cropper__toolbar-right" @click="crop($event)">
                    <button class="o-btn o-btn--xs o-btn--success">done</button>
                </div>
            </div>
        </div>
        <pre>{{ image }}</pre>
    </div>
</template>

<script>
import Cropper from 'cropperjs'
import Rotater from './rotater.vue'

export default {
    props: ['image', 'useRotator', 'ratio'],
    components: {
        'rotater-input': Rotater
    },
    data() {
        return {
            cropper: null,
            rotationValue: 0,
            defaultOptions: {
                background: false
            }
        }
    },
    mounted: function () {
        this.cropper = new Cropper(this.$refs.img, this.options)
    },
    computed: {
        options: function () {
            let ratio = NaN
            if(this.ratio){
                ratio = this.ratio.split(':')
                ratio = ratio[0] / ratio[1]
            }

            const customOptions = {
                aspectRatio: ratio
            }
            return Object.assign(this.defaultOptions, customOptions)
        },
        rotation: {
            get() {
                return this.rotationValue
            },
            set(value) {
                this.rotationValue = value
                this.cropper.rotateTo(this.rotationValue)
            }
        }
    },
    methods: {
        dragImage: function(evt) {
            evt.preventDefault()
            this.cropper.setDragMode('move')
        },
        dragCrop: function(evt) {
            evt.preventDefault()
            this.cropper.setDragMode('crop')
        },
        zoomIn: function(evt) {
            evt.preventDefault()
            this.cropper.zoom(0.1)
        },
        zoomOut: function(evt) {
            evt.preventDefault()
            this.cropper.zoom(-0.1)
        },
        crop: function(evt) {
            this.$emit('crop', this.cropper.getCroppedCanvas().toDataURL())
        }
    }
}
</script>
