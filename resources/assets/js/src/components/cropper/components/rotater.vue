<template>
    <div class="c-cropper__rotater">
        <div class="c-cropper__rotater-wrap" ref="rotater">
            <div class="c-cropper__rotater-track" ref="track" :style="{ transform: `translateX(${trackPosition}px)` }">
                <svg viewBox="0 0 1120 48">
                    <g fill="currentColor">
                        <rect v-for="line in rotatorPoints.lines" :key="'line-' + line.x" :x="line.x" y="0" width="2" :height="line.height"></rect>
                        <text v-for="text in rotatorPoints.text" :key="'text-' + text.x" :x="text.x" y="38" text-anchor="middle">{{ text.text }}</text>
                    </g>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
import { fromEvent, merge } from 'rxjs'
import { filter, map, mergeMap, takeUntil } from 'rxjs/operators'

export default {
    props: ['value'],
    data() {
        return {
            currentRotation: 0,
            moveRotation: 0,
            trackPosition: 0,
            trackPositionStart: 0,
            oneDegreeToPixel: 6,
            maxRotation: 90,
            minRotation: -90
        }
    },
    computed: {
        rotatorPoints: function (){
            let points = new Array(19).fill().map((el, index) => index * 10 - 90)
            let offset = 20
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
    mounted: function (){
        dragRotate.call(this)
        this.trackPositionStart = -this.$refs.track.offsetWidth / 2
        this.trackPosition = this.trackPositionStart
    },
    methods: {
        updateRotation: function (value) {
            let rotation = value / this.oneDegreeToPixel
            rotation = Math.max(Math.min(rotation, this.maxRotation), this.minRotation)
            this.trackPosition = this.trackPositionStart + value
            this.$emit('input', rotation)
        }
    }
}

function dragRotate () {
    const self = this

    const down = merge(
        fromEvent(self.$refs.rotater, 'mousedown'),
        fromEvent(self.$refs.rotater, 'touchstart')
    )

    const move = merge(
        fromEvent(document, 'mousemove'),
        fromEvent(document, 'touchmove')
    )

    const up = merge(
        fromEvent(document, 'mouseup'),
        fromEvent(document, 'touchend')
    )

    down.pipe(
        mergeMap(downEvents => {
            const startPos = getPositionFromEvent(downEvents)

            return move.pipe(
                map(moveEvents => {
                    moveEvents.preventDefault()
                    const movePos = getPositionFromEvent(moveEvents)
                    return {
                        x: movePos.x - startPos.x
                    }
                }),
                takeUntil(up)
            )
        })
    ).subscribe(move => {
        self.moveRatation = move.x * 0.3
        let moveChange = self.currentRotation + self.moveRatation
        moveChange = Math.max(Math.min(moveChange, self.maxRotation * self.oneDegreeToPixel), self.minRotation * self.oneDegreeToPixel)
        self.updateRotation(moveChange)
    })

    up.subscribe(() => {
        self.currentRotation += self.moveRatation
        self.currentRotation = Math.max(Math.min(self.currentRotation, self.maxRotation * self.oneDegreeToPixel), self.minRotation * self.oneDegreeToPixel)
    })
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
