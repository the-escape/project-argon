const gulp = require('gulp')
const fancyLog = require('fancy-log')
const plumber = require('gulp-plumber')
const sourcemaps = require('gulp-sourcemaps')
const sass = require('gulp-sass')
const cached = require('gulp-cached')
const size = require('gulp-size')
const concat = require('gulp-concat')
const cssnano = require('gulp-cssnano')
const header = require('gulp-header')
const rev = require('gulp-rev')
const rimraf = require('rimraf')
const print = require('gulp-print').default
const gPostcss = require('gulp-postcss')
const autoprefixer = require('autoprefixer')

const { onError } = require('./util')
const banner = require('../banner')

function scss (paths) {
    return function scss () {
        fancyLog(' ')
        fancyLog('-> Compiling scss')

        return gulp
            .src(paths.src)
            .pipe(plumber({ errorHandler: onError }))
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(
                sass({
                    includePaths: paths.include
                }).on('error', sass.logError)
            )
            .pipe(cached('sass_compiler'))
            .pipe(sourcemaps.write('./', {}))
            .pipe(size({ gzip: true, showFiles: true }))
            .pipe(gulp.dest(paths.dest))
    }
}

function postcss (paths) {
    return function scss () {
        fancyLog(' ')
        fancyLog('-> Compiling PostCss')

        return gulp
            .src(paths.src)
            .pipe(plumber({ errorHandler: onError }))
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(gPostcss([autoprefixer]))
            .pipe(cached('postcss_compiler'))
            .pipe(sourcemaps.write('./'))
            .pipe(size({ gzip: true, showFiles: true }))
            .pipe(gulp.dest(paths.dest))
    }
}

function css (paths, filename, taskName = 'css') {
    return function css () {
        fancyLog(' ')
        fancyLog('-> Compiling ' + taskName)

        return gulp
            .src(paths.src)
            .pipe(plumber({ errorHandler: onError }))
            .pipe(print())
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(concat(filename))
            .pipe(sourcemaps.write('./'))
            .pipe(size({ gzip: true, showFiles: true }))
            .pipe(gulp.dest(paths.dest))
    }
}

function prodCss (paths, filename, taskName = 'css') {
    return function prodCss () {
        fancyLog(' ')
        fancyLog('-> Compiling Production ' + taskName)

        return gulp
            .src(paths.src)
            .pipe(plumber({ errorHandler: onError }))
            .pipe(print())
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(concat(filename))
            .pipe(
                cssnano({
                    preset: 'default'
                })
            )
            .pipe(header(banner))
            .pipe(sourcemaps.write('./'))
            .pipe(size({ gzip: true, showFiles: true }))
            .pipe(gulp.dest(paths.dest))
    }
}

function revCss (paths) {
    return function revCss () {
        fancyLog(' ')
        fancyLog('-> Revisioning Production css')

        return gulp
            .src(paths.src)
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(print())
            .pipe(rev())
            .pipe(sourcemaps.write('./'))
            .pipe(size({ gzip: true, showFiles: true }))
            .pipe(gulp.dest(paths.dest))
            .pipe(rev.manifest('manifest.json'))
            .pipe(gulp.dest(paths.dest))
    }
}

function cleanCss (paths) {
    return function cleanCss (done) {
        fancyLog(' ')
        fancyLog('-> Cleaning production js folder')

        rimraf(paths.dest, done)
    }
}

module.exports = {
    scss,
    css,
    postcss,
    prodCss,
    revCss,
    cleanCss
}
