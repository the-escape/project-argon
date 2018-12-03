export function createFileInputs (context = document) {
    const fileInputEls = context.querySelectorAll('.js-file')
    let fileInputs = Array.from(fileInputEls)
    fileInputs.forEach(input => createFileInput(input))
}

export function createFileInput (wrapper) {
    const input = wrapper.querySelector('.o-file__input')
    const label = wrapper.querySelector('.o-file__name')
    const preview = wrapper.querySelector('.o-file__image-preview')
    const labelVal = label.innerHTML

    input.addEventListener('change', evt => {
        let fileName = ''

        if (evt.target.files && evt.target.files[0]) {

            const file = evt.target.files[0]

            if(preview && !file.type.match(/image.*/)) {
                label.innerHTML = "<span class='h-text--danger'>You can upload only images.</span>"
                input.type = ''
                input.value = ''
                input.type = 'file'
                
                return 
            }

            fileName = evt.target.value.split('\\').pop()

            // let reader = new FileReader()
            //
            // if (preview && file.type.match(/image.*/)) {
            //
            //     reader.onload = function(readerEvent) {
            //         let image = new Image()
            //
            //         image.onload = function(imageEvent) {
            //             let canvas = document.createElement('canvas'),
            //                 max_size = 200,
            //                 width = image.width,
            //                 height = image.height
            //
            //             if (width > height) {
            //                 if (width > max_size) {
            //                     height += max_size /width
            //                     width = max_size
            //                 }
            //             } else {
            //                 if (height > max_size) {
            //                     width += max_size / height
            //                     height = max_size
            //                 }
            //             }
            //
            //             canvas.width = width
            //             canvas.height = height
            //             canvas.getContext('2d').drawImage(image, 0, 0, width, height)
            //             let dataUrl = canvas.toDataURL('image/jpeg')
            //             let resizedImage = dataURLToBlob(dataUrl)
            //
            //             // input.value = resizedImage
            //             preview.src = dataUrl
            //         }
            //         image.src = readerEvent.target.result
            //     }
                // reader.readAsDataURL(file)

                // reader.onloadend = function() {
                //     preview.src = reader.result
                // }

            // }

            // if (file) {
            //     reader.readAsDataURL(file)
            // }
        }

        if (fileName) {
            label.innerHTML = fileName
        } else {
            label.innerHTML = labelVal
        }
    })
}

// function dataURLToBlob(dataURL) {
//     const BASE64_MARKER = ';base64,'
//     let parts
//     let contentType
//     let raw
//     if (dataURL.indexOf(BASE64_MARKER) == -1) {
//         parts = dataURL.split(',')
//         contentType = parts[0].split(':')[1]
//         raw = parts[1]
//
//         return new Blob([raw], {type: contentType})
//     }
//
//     parts = dataURL.split(BASE64_MARKER)
//     contentType = parts[0].split(':')[1]
//     raw = window.atob(parts[1])
//     let rawLength = raw.length
//
//     let uInt8Array = new Uint8Array(rawLength)
//
//     for (let i = 0; i < rawLength; ++i) {
//         uInt8Array[i] = raw.charCodeAt(i)
//     }
//
//     return new Blob([uInt8Array], {type: contentType})
// }