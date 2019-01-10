const gulp = require('gulp')
const fancyLog = require('fancy-log')
const glob = require('glob')
const concatMulti = require('gulp-concat-multi')
const htmlBeautify = require('gulp-html-beautify')

function buildDemoHtml (paths) {
    var htmlFiles = glob.sync(paths.src)
    var headerFile = paths.meta.head
    var footerFile = paths.meta.foot

    var concatFiles = {}
    for (var i = 0; i < htmlFiles.length; i++) {
        var htmlName = htmlFiles[i]
            .split('/')
            .pop()
            .replace('pages-', '')
        concatFiles[htmlName] = [headerFile, htmlFiles[i], footerFile]
    }

    return function buildDemoHtml () {
        fancyLog('')
        fancyLog('-> compile demo html')

        return concatMulti(concatFiles)
            .pipe(
                htmlBeautify({
                    indent_with_tabs: true,
                    indent_size: 4
                })
            )
            .pipe(gulp.dest(paths.dest))
    }
}

module.exports = {
    buildDemoHtml
}
