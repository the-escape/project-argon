export function createFileInputs (context = document) {
    const fileInputEls = context.querySelectorAll('.js-file')
    let fileInputs = Array.from(fileInputEls)
    fileInputs.forEach(input => createFileInput(input))
}

export function createFileInput (input) {
    const label = input.querySelector('.o-file-upload__name')
    const labelVal = label.innerHTML

    input.addEventListener('change', evt => {
        let fileName = ''
        if (evt.target.files) {
            fileName = evt.target.value.split('\\').pop()
        }

        if (fileName) {
            label.innerHTML = fileName
        } else {
            label.innerHTML = labelVal
        }
    })
}
