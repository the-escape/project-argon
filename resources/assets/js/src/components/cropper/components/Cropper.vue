<template>
    <div class="c-cropper">
        <div class="c-cropper__container">
            <img ref="img" :src="image.path" />
        </div>
        <div class="c-cropper__toolbar">
            <div class="c-cropper__tool-group">
                <button class="o-btn o-btn--sm o-btn--grey" @click="cancel($event)">cancel</button>
            </div>

            <div class="c-cropper__tool-group">
                <button class="c-cropper__btn" @click="rotateNeg45($event)">
                    <div class="c-cropper__icon">
                        <svg><use xlink:href="/argon/images/svgicons.svg#rotate-alt" /></svg>
                    </div>
                </button>
                <button class="c-cropper__btn" @click="rotate45($event)">
                    <div class="c-cropper__icon">
                        <svg><use xlink:href="/argon/images/svgicons.svg#rotate" /></svg>
                    </div>
                </button>
                <button class="c-cropper__btn" @click="mirrorHorizontal($event)">
                    <div class="c-cropper__icon">
                        <svg><use xlink:href="/argon/images/svgicons.svg#flip" /></svg>
                    </div>
                </button>
                <button class="c-cropper__btn" @click="mirrorVertical($event)">
                    <div class="c-cropper__icon">
                        <svg><use xlink:href="/argon/images/svgicons.svg#flip-alt" /></svg>
                    </div>
                </button>
            </div>

            <div class="c-cropper__tool-group">
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

            <div class="c-cropper__tool-group c-cropper__tool-group--center" v-if="useRotator">
                <rotater-input v-model="rotation"></rotater-input>
            </div>

            <div class="c-cropper__tool-group c-cropper__tool-group--end" @click="crop($event)">
                <button class="o-btn o-btn--sm o-btn--success">done</button>
            </div>
        </div>
        <pre>{{ image }}</pre>
    </div>
</template>

<script>
import Cropper from 'cropperjs'
import Rotater from './range-rotater.vue'

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
                background: false,
                dragMode: 'move'
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
                this.rotationValue = Math.max(Math.min(value, 90), -90)
                this.cropper.rotateTo(this.rotationValue)
            }
        }
    },
    methods: {
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
        },
        cancel: function(evt) {
            this.$emit('crop')
        },
        rotateNeg45: function () {
            this.rotation = this.rotation - 45
        },
        rotate45: function () {
            this.rotation = this.rotation + 45
        },
        mirrorHorizontal: function () {
            if(this.cropper.imageData.scaleY === -1){
                this.cropper.scaleY(1)
            }else{
                this.cropper.scaleY(-1)
            }
        },
        mirrorVertical: function () {
            if(this.cropper.imageData.scaleX === -1){
                this.cropper.scaleX(1)
            }else{
                this.cropper.scaleX(-1)
            }
        }
    }
}
</script>
