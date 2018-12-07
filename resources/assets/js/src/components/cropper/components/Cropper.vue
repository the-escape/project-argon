<template>
    <div class="c-cropper">
        <div class="c-cropper__container">
            <img ref="img" :src="image.path" />
            <div class="c-cropper__toolbar">
                <div class="c-cropper__toolbar-left">
                    <button class="c-cropper__btn" @click="dragImage($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#search" /></svg>
                        </div>
                    </button>
                    <button class="c-cropper__btn" @click="dragCrop($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#search" /></svg>
                        </div>
                    </button>
                    <button class="c-cropper__btn" @click="zoomIn($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#search" /></svg>
                        </div>
                    </button>
                    <button class="c-cropper__btn" @click="zoomOut($event)">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#search" /></svg>
                        </div>
                    </button>
                </div>
                <div class="c-cropper__toolbar-mid">
                    <div class="c-cropper__rotater">
                        <div class="c-cropper__rotater-wrap">
                            <div class="c-cropper__rotater-track">
                                <svg viewBox="0 0 1100 48">
                                    <g fill="currentColor">
                                        <rect v-for="line in rotatorPoints.lines" :key="line.x" :x="line.x" y="0" width="2" :height="line.height"></rect>
                                        <text v-for="text in rotatorPoints.text" :key="text.x" :x="text.x" y="38" text-anchor="middle">{{ text.text }}</text>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c-cropper__toolbar-right">
                    <button class="c-cropper__btn" @click="setRatio($event, '16:9')">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#search" /></svg>
                        </div>
                    </button>
                    <button class="c-cropper__btn" @click="setRatio($event, '4:3')">
                        <div class="c-cropper__icon">
                            <svg><use xlink:href="/argon/images/svgicons.svg#search" /></svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <pre>{{ image }}</pre>
    </div>
</template>

<script>
import Cropper from 'cropperjs'

export default {
    props: ['image'],
    data() {
        return {
            cropper: null,
            defaultOptions: {

            }
        }
    },
    mounted: function () {
        this.cropper = new Cropper(this.$refs.img, this.options)
    },
    computed: {
        options: function () {
            return this.defaultOptions
        },
        rotatorPoints: function (){
            let points = new Array(19).fill().map((el, index) => index * 10 - 90)
            let offset = 10
            let space = 12
            let currentX = offset
            points = points.reduce((acc, el) => {
                acc.lines.push({
                    x: currentX,
                    height: 18
                })
                acc.text.push({
                    x: currentX,
                    text: el + '°'
                })

                if(el < 90) {
                    for(let i = 0; i < 4; i++) {
                        currentX += space
                        acc.lines.push({
                            x: currentX,
                            height: 10
                        })
                    }
                }
                currentX += space
                return acc
            }, {
                lines: [],
                text: []
            })
            return points
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
        setRatio: function(evt, ratio) {
            evt.preventDefault()
            ratio = ratio.split(':')
            ratio = ratio[0] / ratio[1]
            console.log(ratio)
            this.cropper.setAspectRatio(ratio)
        }
    }
}
</script>
