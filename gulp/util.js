const fancyLog = require('fancy-log')

function onError (err) {
    fancyLog.error(err)
}

function doneSeries (done) {
    done && done()
}

module.exports = {
    onError,
    doneSeries
}
