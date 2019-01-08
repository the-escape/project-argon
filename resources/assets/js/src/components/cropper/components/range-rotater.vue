<template>
    <div class="c-cropper__range-rotate">
        <div class="c-cropper__range-handle" ref="handle" :style="{ transform: `translateX(${handlePos - offset}px)` }"></div>
        <div class="c-cropper__range-line" ref="line"></div>
    </div>
</template>

<script>
import { fromEvent } from 'rxjs'
import { mergeMap, takeUntil, map } from 'rxjs/operators'

export default {
    props: ['value'],
    data() {
        return {
            handleStartPos: 0,
            handlePos: 0,
            offset: 19,
            max: 90,
            min: -90,
            moveRotation: 0,
            currentRotation: 0,
            oneDegreeToPixel: 0
        }
    },
    watch: {
        value: function (value) {
            this.updateValue(value)
        }
    },
    mounted() {
        this.updateValue(this.value)
        this.handleStartPos = this.$refs.line.offsetWidth / 2
        this.handlePos = this.handleStartPos
        this.oneDegreeToPixel = this.$refs.line.offsetWidth / 180

        const down = fromEvent(this.$refs.handle, 'mousedown')
        const move = fromEvent(document, 'mousemove')
        const up = fromEvent(document, 'mouseup')

        down.pipe(
            mergeMap(downEvent => {
                const startPos = getPositionFromEvent(downEvent)

                return move.pipe(
                    map(moveEvent => {
                        moveEvent.preventDefault()
                        const movePos = getPositionFromEvent(moveEvent)
                        return {
                            x: movePos.x - startPos.x
                        }
                    }),
                    takeUntil(up)
                )
            })
        ).subscribe(({x}) => {
            this.moveRotation = x
            let moveChange = this.currentRotation + this.moveRotation
            moveChange = Math.max(Math.min(moveChange, this.max * this.oneDegreeToPixel), this.min * this.oneDegreeToPixel)
            this.updateRotation(moveChange)
        })

        up.subscribe(() => {
            this.currentRotation += this.moveRotation
            this.currentRotation = Math.max(Math.min(this.currentRotation, this.max * this.oneDegreeToPixel), this.min * this.oneDegreeToPixel)
        })
    },
    methods: {
        updateRotation: function (value) {
            let rotation = value / this.oneDegreeToPixel
            rotation = Math.max(Math.min(rotation, this.max), this.min)
            this.handlePos = this.handleStartPos + value
            this.$emit('input', rotation)
        },
        updateValue: function(value) {
            let rotation = Math.max(Math.min(value, this.max), this.min)
            let posMove = rotation * this.oneDegreeToPixel
            this.handlePos = this.handleStartPos + posMove
        }
    }
}

function getPositionFromEvent (evt) {
    if (evt.touches) {
        evt = evt.touches[0]
    }
    return {
        x: evt.clientX
    }
}
</script>
