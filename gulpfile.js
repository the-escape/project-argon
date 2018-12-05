const { exec } = require('child_process')

const gulp = require('gulp')
const { existsSync } = require('fs')
const fancyLog = require('fancy-log')

const { scss, css, prodCss, revCss, cleanCss, postcss } = require('./gulp/css')
const { compileJS, jsDevMiddleware, cleanJS } = require('./gulp/js')
const { copy, inlineJs, svgStore } = require('./gulp/assets')
const { copyStyleguideCss, buildPatternLab } = require('./gulp/patternlab')
const { buildDemoHtml } = require('./gulp/demo')
const { doneSeries } = require('./gulp/util')
const browserSync = require('browser-sync')

const pkg = require('./package.json')

let config = {
    backendDevelopment: true,
    patternlabDevelopment: false,
    demoHtmlDevelopment: false,
    productionReady: true,
    servBackend: false,
    backendServUrl: '',
    pageExports: ['pages-index']
}

if (existsSync('./build-options.json')) {
    // @ts-ignore
    const buildOptions = require('./build-options.json')
    config = Object.assign(config, buildOptions)
}

// ====================
// setup browserSync
// ====================

if (config.backendDevelopment && config.servBackend) {
    browserSync.create('backend')
}

if (config.demoHtmlDevelopment) {
    browserSync.create('demoHtml')
}

if (config.patternlabDevelopment) {
    browserSync.create('patternLab')
}

function publishArtisan (done) {
    if (config.backendDevelopment) {
        exec(
            'php ../artisan vendor:publish --tag=public --force',
            (error, stdout, stderr) => {
                if (error) {
                    console.error(`exec error: ${error}`)
                } else {
                    console.log(`stdout: ${stdout}`)
                    console.log(`stderr: ${stderr}`)
                }
            }
        )

        done && done()
    }
}

const reload = function (done) {
    fancyLog('-> Reloading Browser')
    fancyLog(' ')

    publishArtisan()

    if (config.backendDevelopment && config.servBackend) {
        browserSync.get('backend').reload()
    }

    if (config.demoHtmlDevelopment) {
        browserSync.get('demoHtml').reload()
    }

    if (config.patternlabDevelopment) {
        browserSync.get('patternLab').reload()
    }

    done && done()
}

// ====================
// css
// ====================

function setupCssPaths () {
    const scssPaths = {
        src: [
            pkg.paths.src.css + pkg.vars.scssName,
            pkg.paths.src.css + pkg.vars.styleguideScssName,
            pkg.paths.src.css + pkg.vars.typographyScssName
        ],
        include: pkg.paths.src.scss,
        dest: pkg.paths.build.css
    }

    const postcssPaths = {
        src: pkg.paths.build.css + '*.css',
        dest: pkg.paths.build.css
    }

    const productionPaths = {
        src: pkg.globs.prodDistCss,
        dest: pkg.paths.build.productionCss
    }

    const typographyProdPaths = {
        src: pkg.paths.build.css + pkg.vars.typographyCssName,
        dest: pkg.paths.build.productionCss
    }

    // pattern lab paths
    const cssPaths = {
        src: pkg.globs.distCss,
        dest: pkg.paths.plPublic.css
    }

    // DemoHTML Paths
    const cssPathsDemoHtml = {
        src: pkg.paths.build.css + '*.*',
        dest: pkg.paths.demo.css
    }

    const prodCssPathsDemoHtml = {
        src: pkg.paths.build.productionCss + '*.*',
        dest: pkg.paths.demo.css
    }

    // Backend Paths
    const cssPathsBackend = {
        src: pkg.paths.build.css + '*.*',
        dest: pkg.paths.public.css
    }

    const prodCssPathsBackend = {
        src: pkg.paths.build.productionCss + '*.*',
        dest: pkg.paths.public.css
    }

    const revCssPathsBackend = {
        src: pkg.paths.public.css + pkg.vars.cssName,
        dest: pkg.paths.public.css
    }

    const clearCssPathsBackend = {
        dest: pkg.paths.public.css
    }

    return {
        scssPaths,
        cssPaths,
        postcssPaths,
        typographyProdPaths,
        productionPaths,
        cssPathsDemoHtml,
        prodCssPathsDemoHtml,
        cssPathsBackend,
        prodCssPathsBackend,
        revCssPathsBackend,
        clearCssPathsBackend
    }
}

function buildCss () {
    const {
        scssPaths,
        cssPaths,
        postcssPaths,
        typographyProdPaths,
        productionPaths,
        cssPathsDemoHtml,
        prodCssPathsDemoHtml,
        cssPathsBackend,
        prodCssPathsBackend,
        revCssPathsBackend,
        clearCssPathsBackend
    } = setupCssPaths()

    let tasks = []

    if (config.backendDevelopment) {
        tasks.push(cleanCss(clearCssPathsBackend))
    }

    tasks.push(scss(scssPaths))
    tasks.push(postcss(postcssPaths))

    if (config.patternlabDevelopment) {
        tasks.push(css(cssPaths, pkg.vars.cssName, 'Patternlab Css'))
    }

    if (
        config.productionReady &&
        (config.backendDevelopment || config.demoHtmlDevelopment)
    ) {
        tasks.push(prodCss(productionPaths, pkg.vars.cssName, 'Production Css'))
        tasks.push(
            prodCss(
                typographyProdPaths,
                pkg.vars.typographyCssName,
                'Typography Production Css'
            )
        )
    }

    if (config.demoHtmlDevelopment) {
        if (config.productionReady) {
            tasks.push(copy(prodCssPathsDemoHtml, 'DemoHtml Production Css'))
        } else {
            tasks.push(copy(cssPathsDemoHtml, 'DemoHtml Css'))
        }
    }

    if (config.backendDevelopment) {
        if (config.productionReady) {
            tasks.push(copy(prodCssPathsBackend, 'Backend Production Css'))
        } else {
            tasks.push(copy(cssPathsBackend, 'Backend Css'))
        }

        tasks.push(revCss(revCssPathsBackend))
    }

    if (!tasks.length) {
        return done => {
            done && done()
        }
    }

    return gulp.series.apply(null, tasks)
}

function watchCss () {
    fancyLog(' ')
    fancyLog('-> Watching Css & Scss')

    gulp.watch(
        pkg.globs.watchCss,
        {
            awaitWriteFinish: true
        },
        gulp.series(buildCss(), reload)
    )
}

// ====================
// js
// ====================

function setupJsPaths () {
    const paths = {
        src: pkg.paths.src.js + pkg.vars.jsName,
        public: pkg.publicPaths.js,
        manifest: pkg.publicPaths.manifest,
        dest: pkg.paths.plPublic.js
    }

    const buildPaths = {
        src: pkg.paths.src.js + pkg.vars.jsName,
        public: pkg.publicPaths.js,
        manifest: pkg.publicPaths.manifest,
        dest: pkg.paths.build.productionJs
    }

    const pathsDemoHtml = {
        src: pkg.globs.distJs,
        dest: pkg.paths.demo.js
    }

    const pathsBackend = {
        src: pkg.globs.distJs,
        dest: pkg.paths.public.js
    }

    return {
        paths,
        buildPaths,
        pathsDemoHtml,
        pathsBackend
    }
}

function buildJS (done) {
    const { buildPaths, pathsDemoHtml, pathsBackend } = setupJsPaths()

    const tasks = []

    if (config.backendDevelopment || config.demoHtmlDevelopment) {
        tasks.push(cleanJS(buildPaths, 'Build JS'))
        tasks.push(
            compileJS(
                buildPaths,
                pkg.vars.prodJsName,
                pkg.vars.vendorChunkName,
                config.productionReady,
                'Build JS'
            )
        )
    }

    if (config.demoHtmlDevelopment) {
        tasks.push(cleanJS(pathsDemoHtml, 'DemoHtml JS'))
        tasks.push(copy(pathsDemoHtml, 'DemoHtml JS'))
    }

    if (config.backendDevelopment) {
        tasks.push(cleanJS(pathsBackend, 'Backend JS'))
        tasks.push(copy(pathsBackend, 'Backend JS'))
    }

    if (!tasks.length) {
        return done => {
            done && done()
        }
    }

    return gulp.series.apply(null, tasks)
}

function getJSDevMiddleware () {
    const { paths, filename } = setupJsPaths()

    return jsDevMiddleware(paths, filename, reload)
}

function watchJS (done) {
    fancyLog(' ')
    fancyLog('-> Watching JS')

    gulp.watch(
        pkg.paths.src.js + '**/*.js',
        {
            awaitWriteFinish: true
        },
        gulp.series(buildJS(), reload)
    )

    gulp.watch(
        pkg.paths.src.js + '**/*.vue',
        {
            awaitWriteFinish: true
        },
        gulp.series(buildJS(), reload)
    )
}

// ====================
// Assets
// ====================

function setupAssetPaths () {
    const inlineJSPaths = {
        src: pkg.globs.inlineJs,
        dest: pkg.paths.plPublic.vendorjs
    }

    const vendorJSPaths = {
        src: pkg.globs.vendorJs,
        dest: pkg.paths.plPublic.vendorjs
    }

    const fontPaths = {
        src: pkg.paths.src.fonts + '**/*.*',
        dest: pkg.paths.plPublic.fonts
    }

    const imagePaths = {
        src: pkg.paths.src.img + '**/*.*',
        dest: pkg.paths.plPublic.img
    }

    const faviconPaths = {
        src: pkg.paths.src.base + pkg.vars.faviconName,
        dest: pkg.paths.plPublic.base
    }

    const svgPaths = {
        src: pkg.paths.src.svgicons + '*.svg',
        dest: pkg.paths.src.img
    }

    // DemoHTML Paths
    const inlineJSPathsDemoHtml = {
        src: pkg.globs.inlineJs,
        dest: pkg.paths.demo.vendorjs
    }

    const vendorJSPathsDemoHtml = {
        src: pkg.globs.vendorJs,
        dest: pkg.paths.demo.vendorjs
    }

    const fontPathsDemoHtml = {
        src: pkg.paths.src.fonts + '**/*.*',
        dest: pkg.paths.demo.fonts
    }

    const imagePathsDemoHtml = {
        src: pkg.paths.src.img + '**/*.*',
        dest: pkg.paths.demo.img
    }

    const faviconPathsDemoHtml = {
        src: pkg.paths.src.base + pkg.vars.faviconName,
        dest: pkg.paths.demo.base
    }

    // Backend Paths
    const inlineJSPathsBackend = {
        src: pkg.globs.inlineJs,
        dest: pkg.paths.public.vendorjs
    }

    const vendorJSPathsBackend = {
        src: pkg.globs.vendorJs,
        dest: pkg.paths.public.vendorjs
    }

    const fontPathsBackend = {
        src: pkg.paths.src.fonts + '**/*.*',
        dest: pkg.paths.public.fonts
    }

    const imagePathsBackend = {
        src: pkg.paths.src.img + '**/*.*',
        dest: pkg.paths.public.img
    }

    return {
        inlineJSPaths,
        vendorJSPaths,
        fontPaths,
        imagePaths,
        faviconPaths,
        svgPaths,
        inlineJSPathsDemoHtml,
        vendorJSPathsDemoHtml,
        fontPathsDemoHtml,
        imagePathsDemoHtml,
        faviconPathsDemoHtml,
        inlineJSPathsBackend,
        vendorJSPathsBackend,
        fontPathsBackend,
        imagePathsBackend
    }
}

function updateAssets () {
    const {
        inlineJSPaths,
        vendorJSPaths,
        fontPaths,
        imagePaths,
        faviconPaths,
        svgPaths,
        inlineJSPathsDemoHtml,
        vendorJSPathsDemoHtml,
        fontPathsDemoHtml,
        imagePathsDemoHtml,
        faviconPathsDemoHtml,
        inlineJSPathsBackend,
        vendorJSPathsBackend,
        fontPathsBackend,
        imagePathsBackend
    } = setupAssetPaths()

    let tasks = []
    tasks.push(svgStore(svgPaths))

    if (config.patternlabDevelopment) {
        tasks = tasks.concat([
            inlineJs(inlineJSPaths, pkg.vars.inlineJs, 'PatternLab Inline js'),
            copy(vendorJSPaths, 'PatternLab VendorJS'),
            copy(fontPaths, 'PatternLab Fonts'),
            copy(imagePaths, 'PatternLab Images'),
            copy(faviconPaths, 'PatternLab Favicon')
        ])
    }

    if (config.demoHtmlDevelopment) {
        tasks = tasks.concat([
            inlineJs(
                inlineJSPathsDemoHtml,
                pkg.vars.inlineJs,
                'DemoHtml Inline js'
            ),
            copy(vendorJSPathsDemoHtml, 'DemoHtml VendorJS'),
            copy(fontPathsDemoHtml, 'DemoHtml Fonts'),
            copy(imagePathsDemoHtml, 'DemoHtml Images'),
            copy(faviconPathsDemoHtml, 'DemoHtml Favicon')
        ])
    }

    if (config.backendDevelopment) {
        tasks = tasks.concat([
            inlineJs(
                inlineJSPathsBackend,
                pkg.vars.inlineJs,
                'Backend Inline js'
            ),
            copy(vendorJSPathsBackend, 'Backend VendorJS'),
            copy(fontPathsBackend, 'Backend Fonts'),
            copy(imagePathsBackend, 'Backend Images')
        ])
    }

    if (!tasks.length) {
        return done => {
            done && done()
        }
    }

    return gulp.series.apply(null, tasks)
}

function watchAssets () {
    const {
        fontPaths,
        imagePaths,
        faviconPaths,
        svgPaths,
        fontPathsDemoHtml,
        imagePathsDemoHtml,
        faviconPathsDemoHtml,
        fontPathsBackend,
        imagePathsBackend
    } = setupAssetPaths()

    const fontTasks = []
    const imageTasks = []
    const faviconTasks = []

    if (config.patternlabDevelopment) {
        fontTasks.push(copy(fontPaths, 'PatternLab Fonts'))
        imageTasks.push(copy(imagePaths, 'PatternLab Images'))
        faviconTasks.push(copy(faviconPaths, 'PatternLab Favicon'))
    }

    if (config.demoHtmlDevelopment) {
        fontTasks.push(copy(fontPathsDemoHtml, 'DemoHtml Fonts'))
        imageTasks.push(copy(imagePathsDemoHtml, 'DemoHtml Images'))
        faviconTasks.push(copy(faviconPathsDemoHtml, 'DemoHtml Favicon'))
    }

    if (config.backendDevelopment) {
        fontTasks.push(copy(fontPathsBackend, 'Backend Fonts'))
        imageTasks.push(copy(imagePathsBackend, 'Backend Images'))
    }

    fancyLog(' ')
    fancyLog('-> Watching fonts, images and favicon')
    if (fontTasks.length) {
        const fonts = gulp.series.apply(null, fontTasks)
        gulp.watch(
            fontPaths.src,
            {
                awaitWriteFinish: true
            },
            gulp.series(fonts, reload)
        )
    }

    if (imageTasks.length) {
        const image = gulp.series.apply(null, imageTasks)
        gulp.watch(
            imagePaths.src,
            {
                awaitWriteFinish: true
            },
            gulp.series(image, reload)
        )
        gulp.watch(
            svgPaths.src,
            {
                awaitWriteFinish: true
            },
            gulp.series(svgStore(svgPaths), image, reload)
        )
    }

    if (faviconTasks.length) {
        const favicon = gulp.series.apply(null, faviconTasks)
        gulp.watch(
            faviconPaths.src,
            {
                awaitWriteFinish: true
            },
            gulp.series(favicon, reload)
        )
    }
}

// ====================
// Pattern Lab
// ====================

function updatePatternLabAssets () {
    const copyStyleGuidePaths = {
        src: pkg.paths.src.styleguide + '**/!(*.css)',
        dest: pkg.paths.plPublic.base
    }

    const copyStyleGuideCssPaths = {
        src: pkg.paths.src.styleguide + '**/*.css',
        dest: pkg.paths.plPublic.styleguide
    }

    const copyStyleguide = copy(copyStyleGuidePaths, 'styleguide files')
    const copyStyleguideCssFn = copyStyleguideCss(copyStyleGuideCssPaths)

    return gulp.series(copyStyleguideCssFn, copyStyleguide)
}

function watchStyleGuideFiles () {
    fancyLog('')
    fancyLog('-> Watching Styleguide files')

    const updatePatternLabAssetsFn = updatePatternLabAssets()

    gulp.watch(
        pkg.paths.src.styleguide + '**/!(*.css)',
        {
            awaitWriteFinish: true
        },
        gulp.series(updatePatternLabAssetsFn, reload)
    )
    gulp.watch(
        pkg.paths.src.styleguide + '**/*.css',
        {
            awaitWriteFinish: true
        },
        gulp.series(updatePatternLabAssetsFn, reload)
    )
}

function patternLabBuild () {
    return gulp.series(
        updatePatternLabAssets(),
        buildPatternLab(config.pageExports, pkg.paths)
    )
}

function watchPatternLab () {
    fancyLog('')
    fancyLog('-> Watching Pattern Lab source files')

    const build = buildPatternLab(config.pageExports, pkg.paths)
    let buildSeries = gulp.series(build, done => {
        if (config.patternlabDevelopment) {
            browserSync.get('patternLab').reload()
        }
        done && done()
    })

    gulp.watch(
        pkg.paths.src.patterns + '**/*.json',
        {
            awaitWriteFinish: true
        },
        buildSeries
    )
    gulp.watch(
        pkg.paths.src.patterns + '**/*.md',
        {
            awaitWriteFinish: true
        },
        buildSeries
    )
    gulp.watch(
        pkg.paths.src.patterns + '**/*.mustache',
        {
            awaitWriteFinish: true
        },
        buildSeries
    )
    gulp.watch(
        pkg.paths.src.data + '**/*.json',
        {
            awaitWriteFinish: true
        },
        buildSeries
    )
    gulp.watch(
        pkg.paths.src.meta + '**/*',
        {
            awaitWriteFinish: true
        },
        buildSeries
    )
    gulp.watch(
        pkg.paths.src.annotations + '**/*',
        {
            awaitWriteFinish: true
        },
        buildSeries
    )
}

// ====================
// Serv
// ====================

function serv () {
    const browserSyncConfig = () => ({
        notify: {
            styles: [
                'display: none',
                'padding: 15px',
                'font-family: sans-serif',
                'position: fixed',
                'font-size: 1em',
                'z-index: 9999',
                'bottom: 0px',
                'right: 0px',
                'border-top-left-radius: 5px',
                'background-color: #1B2032',
                'opacity: 0.4',
                'margin: 0',
                'color: white',
                'text-align: center'
            ]
        }
    })
    const tasks = []

    if (config.patternlabDevelopment) {
        const patternLabBrowserSyncConfig = browserSyncConfig()

        patternLabBrowserSyncConfig.server = {
            baseDir: pkg.paths.plPublic.base
        }

        patternLabBrowserSyncConfig.port = 3000
        patternLabBrowserSyncConfig.ui = {
            port: 3001
        }
        patternLabBrowserSyncConfig.middleware = [getJSDevMiddleware()]

        tasks.push(done => {
            browserSync
                .get('patternLab')
                .init(patternLabBrowserSyncConfig, function () {
                    fancyLog(' ')
                    fancyLog('-> Starting BrowserSync')
                    done && done()
                })
        })
    }

    if (config.demoHtmlDevelopment) {
        const demoHtmlBrowserSyncConfig = browserSyncConfig()

        demoHtmlBrowserSyncConfig.server = {
            baseDir: pkg.paths.demo.base
        }

        demoHtmlBrowserSyncConfig.port = 3002
        demoHtmlBrowserSyncConfig.ui = {
            port: 3003
        }

        tasks.push(done => {
            browserSync
                .get('demoHtml')
                .init(demoHtmlBrowserSyncConfig, function () {
                    fancyLog(' ')
                    fancyLog('-> Starting BrowserSync')
                    done && done()
                })
        })
    }

    if (
        config.backendDevelopment &&
        config.servBackend &&
        config.backendServUrl
    ) {
        const backendBrowserSyncConfig = browserSyncConfig()
        backendBrowserSyncConfig.proxy = config.backendServUrl

        tasks.push(done => {
            browserSync
                .create('backend')
                .init(backendBrowserSyncConfig, function () {
                    fancyLog(' ')
                    fancyLog('-> Starting BrowserSync')
                    done && done()
                })
        })
    }

    if (!tasks.length) {
        return done => {
            done && done()
        }
    }

    return gulp.series.apply(null, tasks)
}

// ====================
// Demo
// ====================

function buildDemo () {
    if (!config.demoHtmlDevelopment) {
        return done => {
            done && done()
        }
    }

    const htmlPaths = {
        src: pkg.paths.productionSrc.pages + '*.html',
        meta: {
            head: pkg.paths.productionSrc.meta + pkg.vars.productionHeaderName,
            foot: pkg.paths.productionSrc.meta + pkg.vars.productionFooterName
        },
        dest: pkg.paths.demo.base
    }

    const buildHtml = buildDemoHtml(htmlPaths)

    return gulp.series(buildHtml)
}

function watchHtml () {
    if (!config.demoHtmlDevelopment) {
        return
    }

    fancyLog('-> Watching pattern lab page exports')

    gulp.watch(
        pkg.paths.productionSrc.pages + '*.html',
        {
            awaitWriteFinish: true
        },
        gulp.series(buildDemo(), done => {
            browserSync.get('demoHtml').reload()
            done && done()
        })
    )
}

// ====================
// OLD CMS
// ====================

function setupOldCMSPaths () {
    const fontPaths = {
        src: 'bower_components/font-awesome/fonts/**/*.*',
        dest: pkg.paths.public.fonts
    }

    const fontPathsPL = {
        src: 'bower_components/font-awesome/fonts/**/*.*',
        dest: pkg.paths.plPublic.fonts
    }

    const jsGlob = [
        'bower_components/jquery/dist/jquery.*',
        'bower_components/jquery.ui/ui/core.js',
        'bower_components/jquery.ui/ui/widget.js',
        'bower_components/jquery.ui/ui/mouse.js',
        'bower_components/jquery.ui/ui/accordion.js',
        'bower_components/jquery.ui/ui/sortable.js',
        'bower_components/bootstrap/dist/js/bootstrap.*',
        'bower_components/tether/dist/js/tether.min.js',
        'bower_components/jstree/dist/jstree.min.js',
        'bower_components/dropzone/dist/min/dropzone.min.js',
        'bower_components/handlebars/handlebars.min.js',
        'bower_components/fancybox/source/jquery.fancybox.pack.js'
    ]

    const jsPaths = {
        src: jsGlob,
        dest: pkg.paths.public.js
    }

    const jsPathsPL = {
        src: jsGlob,
        dest: pkg.paths.plPublic.js
    }

    const jsTreePaths = {
        src: 'bower_components/jstree/dist/themes/default/**/*.*',
        dest: pkg.paths.public.js + 'jstree/'
    }

    const jsTreePathsPL = {
        src: 'bower_components/jstree/dist/themes/default/**/*.*',
        dest: pkg.paths.plPublic.js + 'jstree/'
    }

    const ckeditorPaths = {
        src: 'bower_components/ckeditor/**/*.*',
        dest: pkg.paths.public.js + 'ckeditor/'
    }

    const ckeditorPathsPL = {
        src: 'bower_components/ckeditor/**/*.*',
        dest: pkg.paths.plPublic.js + 'ckeditor/'
    }

    const acePaths = {
        src: 'bower_components/ace-builds/src-min/**/*.*',
        dest: pkg.paths.public.js + 'ace/'
    }

    const acePathsPL = {
        src: 'bower_components/ace-builds/src-min/**/*.*',
        dest: pkg.paths.plPublic.js + 'ace/'
    }

    const fancyboxPaths = {
        src: 'bower_components/fancybox/source/**/*.*',
        dest: pkg.paths.public.css + 'fancybox/'
    }

    const fancyboxPathsPL = {
        src: 'bower_components/fancybox/source/**/*.*',
        dest: pkg.paths.plPublic.css + 'fancybox/'
    }

    const oldCmsJSPath = pkg.paths.src.base + 'js/old-cms/'

    const argonJSGlob = [
        oldCmsJSPath + 'argon.js',
        oldCmsJSPath + 'fields.js',
        oldCmsJSPath + 'fields/boolean.js',
        oldCmsJSPath + 'fields/button.js',
        oldCmsJSPath + 'fields/combo.js',
        oldCmsJSPath + 'fields/datetime.js',
        oldCmsJSPath + 'fields/file.js',
        oldCmsJSPath + 'fields/item.js',
        oldCmsJSPath + 'fields/select.js',
        oldCmsJSPath + 'fields/text.js',
        oldCmsJSPath + 'fields/wysiwyg.js',
        oldCmsJSPath + 'fields/location.js',
        oldCmsJSPath + 'localisations.js'
    ]

    const argonJSPaths = {
        src: argonJSGlob,
        dest: pkg.paths.public.js
    }

    const argonJSPathsPL = {
        src: argonJSGlob,
        dest: pkg.paths.plPublic.js
    }

    const scssPaths = {
        src: pkg.paths.src.css + 'old-cms.scss',
        include: 'bower_components/bootstrap/scss',
        dest: pkg.paths.build.css
    }

    const argonScssPaths = {
        src: pkg.paths.build.css + 'old-cms.*',
        dest: pkg.paths.public.css
    }

    const argonScssPathsPL = {
        src: pkg.paths.build.css + 'old-cms.*',
        dest: pkg.paths.plPublic.css
    }

    return {
        fontPaths,
        fontPathsPL,
        jsPaths,
        jsPathsPL,
        jsTreePaths,
        jsTreePathsPL,
        ckeditorPaths,
        ckeditorPathsPL,
        acePaths,
        acePathsPL,
        fancyboxPaths,
        fancyboxPathsPL,
        argonJSPaths,
        argonJSPathsPL,
        scssPaths,
        argonScssPaths,
        argonScssPathsPL
    }
}

function copyCmsAssets () {
    const {
        fontPaths,
        fontPathsPL,
        jsPaths,
        jsPathsPL,
        jsTreePaths,
        jsTreePathsPL,
        ckeditorPaths,
        ckeditorPathsPL,
        acePaths,
        acePathsPL,
        fancyboxPaths,
        fancyboxPathsPL,
        argonJSPaths,
        argonJSPathsPL,
        scssPaths,
        argonScssPaths,
        argonScssPathsPL
    } = setupOldCMSPaths()

    const tasks = []

    tasks.push(scss(scssPaths))

    if (config.patternlabDevelopment) {
        tasks.push(copy(fontPathsPL, 'OLD-CMS Font Awesome PL'))
        tasks.push(copy(jsPathsPL, 'OLD-CMS JS PL'))
        // tasks.push(copy(jsTreePathsPL, 'OLD-CMS jstree PL'))
        // tasks.push(copy(ckeditorPathsPL, 'OLD-CMS ckeditor PL'))
        tasks.push(copy(acePathsPL, 'OLD-CMS ace PL'))
        tasks.push(copy(fancyboxPathsPL, 'OLD-CMS fancybox PL'))
        tasks.push(inlineJs(argonJSPathsPL, 'argon.js', 'OlD CMD js PL'))
        tasks.push(copy(argonScssPathsPL, 'OLD-CMS css'))
    }

    if (config.backendDevelopment) {
        tasks.push(copy(fontPaths, 'OLD-CMS Font Awesome'))
        tasks.push(copy(jsPaths, 'OLD-CMS JS'))
        // tasks.push(copy(jsTreePaths, 'OLD-CMS jstree'))
        // tasks.push(copy(ckeditorPaths, 'OLD-CMS ckeditor'))
        tasks.push(copy(acePaths, 'OLD-CMS ace'))
        tasks.push(copy(fancyboxPaths, 'OLD-CMS fancybox'))
        tasks.push(inlineJs(argonJSPaths, 'argon.js', 'OlD CMD js'))
        tasks.push(copy(argonScssPaths, 'OLD-CMS css'))
    }

    if (!tasks.length) {
        return done => {
            done && done()
        }
    }

    return gulp.series.apply(null, tasks)
}

function watchOldCms () {
    fancyLog('-> Watching Old CMS CSS')

    gulp.watch(
        pkg.paths.src.css + 'old-cms.scss',
        {
            awaitWriteFinish: true
        },
        gulp.series(copyCmsAssets(), reload)
    )

    gulp.watch(
        pkg.paths.src.css + '/old-cms/**/*.scss',
        {
            awaitWriteFinish: true
        },
        gulp.series(copyCmsAssets(), reload)
    )
}

// ====================
// Tasks
// ====================

function watch () {
    watchCss()
    watchJS()
    watchAssets()
    watchStyleGuideFiles()
    watchPatternLab()
    watchHtml()
    watchOldCms()
}

gulp.task(
    'default',
    gulp.series(
        updatePatternLabAssets(),
        updateAssets(),
        buildCss(),
        buildJS(),
        patternLabBuild(),
        buildDemo(),
        copyCmsAssets(),
        doneSeries,
        publishArtisan
    )
)
gulp.task('js', gulp.series(buildJS(), doneSeries, publishArtisan))
gulp.task('css', gulp.series(buildCss(), doneSeries, publishArtisan))
gulp.task(
    'demoHtml',
    gulp.series(patternLabBuild(), buildDemo(), doneSeries, publishArtisan)
)
gulp.task('old-cms', gulp.series(copyCmsAssets(), doneSeries, publishArtisan))
gulp.task(
    'watch',
    gulp.series(
        updatePatternLabAssets(),
        updateAssets(),
        buildCss(),
        buildJS(),
        patternLabBuild(),
        buildDemo(),
        copyCmsAssets(),
        publishArtisan,
        watch
    )
)
gulp.task(
    'serv',
    gulp.series(
        updatePatternLabAssets(),
        updateAssets(),
        buildCss(),
        buildJS(),
        patternLabBuild(),
        buildDemo(),
        copyCmsAssets(),
        publishArtisan,
        gulp.parallel(serv(), watch)
    )
)
