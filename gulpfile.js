var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    cssnano = require('gulp-cssnano'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer');

var nodeModules = 'node_modules/';

function error (e) {
    console.log(e.toString());
    this.emit('end');
}

gulp.task('libs-js', function () {
    gulp.src([
        nodeModules + 'jquery/dist/jquery.min.js',
        nodeModules + 'bootstrap/dist/js/bootstrap.js',
        nodeModules + 'parsleyjs/dist/parsley.js'
    ])
        .pipe(sourcemaps.init())
        .pipe(concat('libs.min.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/assets/js'))
        .pipe(gulp.dest('../public/argon/assets/js'));
});

gulp.task('libs-css', function () {
    gulp.src([
        nodeModules + 'bootstrap/dist/css/bootstrap.css'
    ])
        .pipe(sourcemaps.init())
        .pipe(concat('libs.min.css'))
        .pipe(cssnano({
            discardComments: {
                removeAll: true
            }
        }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/assets/css'))
        .pipe(gulp.dest('../public/argon/assets/css'));
});

gulp.task('js', function () {
    gulp.src('resources/assets/js/**/*.js')
        .pipe(sourcemaps.init())
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write())
        .on('error', error)
        .pipe(gulp.dest('public/assets/js'))
        .pipe(gulp.dest('../public/argon/assets/js'));
});

gulp.task('sass', function () {
    gulp.src('resources/assets/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            compress: true
        }))
        .on('error', error)
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(cssnano({
            discardComments: {
                removeAll: true
            }
        }))
        .pipe(concat('main.min.css'))
        .pipe(sourcemaps.write())
        .on('error', error)
        .pipe(gulp.dest('public/assets/css'))
        .pipe(gulp.dest('../public/argon/assets/css'));
});

gulp.task('watch', function () {
    gulp.watch('resources/assets/js/**/*.js', ['js']);
    gulp.watch('resources/assets/sass/**/*.scss', ['sass']);
});

gulp.task('default', ['libs-js', 'libs-css', 'js', 'sass']);
