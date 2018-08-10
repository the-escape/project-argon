import { fromEvent } from 'rxjs'
import { map } from 'rxjs/operators'

const MediaInput = {
    el: null,
    thumb: null,
    src: null,
    alt: null,
    selectBtn: null
}

export function createMediaInputs (context = document) {
    const mediaInputEls = context.querySelectorAll('.js-media-input')
    let mediaInputs = Array.from(mediaInputEls)
    mediaInputs.forEach(input => createMediaInput(input))
}

export function createMediaInput (input) {
    const Obj = Object.create(MediaInput)
    init.call(Obj, input)
    return Obj
}

function init(input){
    if(!input){
        return
    }

    this.thumb = input.querySelector('.js-media-input-preview')
    this.id = input.querySelector('[data-input-item-name=id]')
    this.url = input.querySelector('[data-input-item-name=url]')
    this.width = input.querySelector('[data-input-item-name=width]')
    this.height = input.querySelector('[data-input-item-name=height]')
    const alt = input.querySelector('[data-input-item-name=alt]').value
    this.selectBtn = input.querySelector('.js-media-input-select')

    updateThumb.call(this)

    // this.thumb.src = this.url.value
    // this.thumb.alt = alt

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

function setValues(values){
    this.id.value = values.id
    this.url.value = values.url
    this.width.value = values.width
    this.height.value = values.height

    updateThumb.call(this)
}

function updateThumb(){
    this.thumb.src = this.url.value
    this.thumb.alt = ''
}

export function spawnMediaLibModal() {
    return new Promise(res => {
        $('#medialib').off('hidden.bs.modal')
        $('#medialib').on('hidden.bs.modal', function () {
            const id = $(this).data('mlselect')
            let mediaValueObj
            // data.values

            $.ajax(argon.root() + '/media/items/' + id).done(function (r) {

                mediaValueObj = {
                    id: r.id,
                    url: r.url,
                    width: r.meta.width,
                    height: r.meta.height,
                    alt: ''
                }

                res(mediaValueObj)
            });
        })

        $('#medialib').modal()
    })
}