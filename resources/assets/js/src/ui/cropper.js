import Cropper from 'cropperjs'
import { fromEvent, merge } from 'rxjs'
import { filter, map, mergeMap, takeUntil, debounceTime } from 'rxjs/operators'

let el
let container
let canvas
let input
let preview
let rotate

let currentRotation = 0
let moveRatation = 0

let cropper

export function CreateCropper () {
    el = document.querySelector('.js-cropper')

    if (!el) {
        return
    }

    container = el.querySelector('.js-cropper-container')
    canvas = document.createElement('canvas')
    container.appendChild(canvas)
    input = el.querySelector('.js-cropper-int')
    preview = el.querySelector('.js-cropper-out-preview')
    rotate = el.querySelector('.js-cropper-rotate')

    cropper = new Cropper(canvas, {
        preview: preview
    })

    input.addEventListener('change', imageSet)
    fromEvent(el, 'click')
        .pipe(
            filter(evt => evt.target.dataset.task),
            map(evt => ({
                task: evt.target.dataset.task,
                element: evt.target
            }))
        )
        .subscribe(runTask)

    dragRotate()
}

function dragRotate () {
    const down = merge(
        fromEvent(rotate, 'mousedown'),
        fromEvent(rotate, 'touchstart')
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
        moveRatation = move.x * 0.3
        cropper.rotateTo(currentRotation + moveRatation)
    })

    up.subscribe(() => {
        console.log('up')
        currentRotation += moveRatation
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

function runTask ({ task, element }) {
    switch (task) {
    case 'zoom-in':
        cropper.zoom(0.1)
        break
    case 'zoom-out':
        cropper.zoom(-0.1)
        break
    case 'drag-image':
        cropper.setDragMode('move')
        break
    case 'drag-crop':
        cropper.setDragMode('crop')
        break
    case 'set-ratio':
        let ratio = element.dataset.ratio
        ratio = ratio.split(':')
        ratio = ratio[0] / ratio[1]
        console.log(ratio)
        cropper.setAspectRatio(ratio)
        break
    case 'set-rotate':
        let rotate = element.dataset.rotate
        currentRotation = 0
        cropper.rotateTo(rotate)
        break
    }
}

function imageSet (evt) {
    const file = evt.target.files[0]

    const reader = new FileReader()
    reader.onload = evt => {
        cropper.replace(evt.target.result)
    }

    reader.readAsDataURL(file)
}
