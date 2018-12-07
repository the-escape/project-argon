import Vue from 'vue'
import App from './App.vue'

let cropper

export function Cropper () {
    const cropperEl = document.createElement('div')
    cropperEl.classList.add('.c-cropper__wrapper')
    document.body.appendChild(cropperEl)

    cropper = new Vue({
        render: h => h(App)
    }).$mount(cropperEl)
}

export function setCropperImage (image) {
    return new Promise(resolve => {
        cropper.$emit('setImage', image)
        cropper.$on('cropImage', resolve)
    })
}
