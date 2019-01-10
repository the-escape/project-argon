export const post = (url, data, contentType = 'application/json') =>
    new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest()
        xhr.open('POST', url, true)
        xhr.setRequestHeader('Content-type', contentType)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                resolve(xhr.responseText)
            } else if (
                xhr.readyState === XMLHttpRequest.DONE &&
                xhr.status !== 200
            ) {
                reject(xhr.responseText)
            }
        }

        if (typeof data === 'object') {
            data = JSON.stringify(data)
        }

        xhr.send(data)
    })
