export function createMediaInputs (context = document) {
    const mediaInputEls = context.querySelectorAll('.js-media-input')
    let mediaInputs = Array.from(mediaInputEls)
    mediaInputs.forEach(input => createMediaInput(input))
}

export function createMediaInput (input) {
    const thumb = input.querySelector('img')
    const url = input.querySelector('[data-input-item-name=url]')


}
