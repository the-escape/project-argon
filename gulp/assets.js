const gulp = require('gulp')
const fancyLog = require('fancy-log')
const plumber = require('gulp-plumber')
const size = require('gulp-size')
const concat = require('gulp-concat')
const svgstore = require('gulp-svgstore')

const { onError } = require('./util')

function copy (path, assetName) {
    return function copy () {
        fancyLog(' ')
        fancyLog('-> Copying ' + assetName)

        return gulp
            .src(path.src)
            .pipe(plumber({ errorHandler: onError }))
            .pipe(gulp.dest(path.dest))
    }
}

function inlineJs (paths, filename, assetName = 'inline js') {
    return function inlineJs () {
        fancyLog(' ')
        fancyLog('-> Concating ' + assetName)

        return gulp
            .src(paths.src)
            .pipe(plumber({ errorHandler: onError }))
            .pipe(concat(filename))
            .pipe(gulp.dest(paths.dest))
    }
}

function svgStore (paths) {
    return function svgStore () {
        fancyLog(' ')
        fancyLog('-> Compiling svgs')

        return gulp
            .src(paths.src)
            .pipe(svgstore())
            .pipe(gulp.dest(paths.dest))
    }
}

module.exports = {
    copy,
    inlineJs,
    svgStore
}
