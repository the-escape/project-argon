import { fromEvent } from 'rxjs'
import { map } from 'rxjs/operators'

const MediaInput = {
    el: null,
    type: null,
    thumb: null,
    // filepath: null,
    src: null,
    alt: null,
    width: null,
    height: null,
    selectBtn: null
}

export function createMediaInputs (context = document) {
    const mediaImageEls = context.querySelectorAll('.js-media-image')
    const mediaFileEls = context.querySelectorAll('.js-media-file')
    let mediaImages = Array.from(mediaImageEls)
    let mediaFiles = Array.from(mediaFileEls)
    mediaImages.forEach(input => createMediaInput(input, 'image'))
    mediaFiles.forEach(input => createMediaInput(input, 'file'))
}

export function createMediaInput (input, type) {
    const Obj = Object.create(MediaInput)
    init.call(Obj, input, type)
    return Obj
}

function init (input, type) {
    if (!input) {
        return
    }

    this.id = input.querySelector('[data-input-item-name=id]')
    this.url = input.querySelector('[data-input-item-name=url]')
    // this.filepath = input.querySelector('.js-media-input-filepath')
    this.selectBtn = input.querySelector('.js-media-input-select')
    this.type = type

    if (type === 'image') {
        this.thumb = input.querySelector('.js-media-input-preview')
        this.width = input.querySelector('[data-input-item-name=width]')
        this.height = input.querySelector('[data-input-item-name=height]')
        const alt = input.querySelector('[data-input-item-name=alt]').value
    }

    updateThumb.call(this)

    fromEvent(this.selectBtn, 'click')
        .pipe(
            map(evt => {
                evt.preventDefault()
                return evt
            })
        )
        .subscribe(() => {
            spawnMediaLibModal().then(setValues.bind(this))
        })
}

function setValues (values) {
    this.id.value = values.id
    this.url.value = values.url

    if (this.type === 'image') {
        this.width.value = values.width
        this.height.value = values.height
    }

    updateThumb.call(this)
}

function updateThumb () {
    if (this.type === 'image') {
        this.thumb.src = this.url.value
        this.thumb.alt = ''
    }
    // else {
    //     this.filepath.innerHTML = this.url.value
    // }
}

export function spawnMediaLibModalForFile () {
    return spawnMediaLibModal('file')
}

export function spawnMediaLibModalForImage () {
    return spawnMediaLibModal('image')
}

function spawnMediaLibModal (type) {
    return new Promise(resolve => {
        $('#medialib').off('hidden.bs.modal')
        $('#medialib').on('hidden.bs.modal', function () {
            const id = $(this).data('mlselect')
            let mediaValueObj
            // data.values

            $.ajax(argon.root() + '/media/items/' + id).done(function (r) {
                if (type === 'image') {
                    mediaValueObj = {
                        id: r.id,
                        url: r.url,
                        width: r.meta.width,
                        height: r.meta.height,
                        alt: ''
                    }
                } else {
                    mediaValueObj = {
                        id: r.id,
                        url: r.url
                    }
                }

                resolve(mediaValueObj)
            })
        })

        $('#medialib').modal()
    })
}
