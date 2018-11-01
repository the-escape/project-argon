const gulp = require('gulp')
const fancyLog = require('fancy-log')
const plumber = require('gulp-plumber')
const print = require('gulp-print').default
const size = require('gulp-size')
const webpackStream = require('webpack-stream')
const webpack = require('webpack')
const MinifyPlugin = require('babel-minify-webpack-plugin')
const ManifestPlugin = require('webpack-manifest-plugin')
const WebpackDevMiddleware = require('webpack-dev-middleware')
const rimraf = require('rimraf')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer')
    .BundleAnalyzerPlugin
const VueLoaderPlugin = require('vue-loader/lib/plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const { onError } = require('./util')
const banner = require('../banner')

function setupWebackConfig (
    paths,
    filename,
    chunkName,
    productionBuild = false,
    isDevMiddleware = false
) {
    const config = {
        entry: paths.src,
        output: {
            filename: filename,
            chunkFilename: chunkName,
            publicPath: paths.public,
            pathinfo: true
        },
        mode: 'development',
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader'
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader'
                },
                {
                    test: /\.css$/,
                    use: [
                        process.env.NODE_ENV !== 'production'
                            ? 'vue-style-loader'
                            : MiniCssExtractPlugin.loader,
                        'css-loader'
                    ]
                }
            ]
        },
        plugins: [
            new VueLoaderPlugin(),
            new MiniCssExtractPlugin({
                filename: 'vue.css'
            })
        ],
        optimization: {
            namedModules: true,
            concatenateModules: true,
            minimize: false
        }
    }

    if (!isDevMiddleware) {
        config.optimization.splitChunks = {
            cacheGroups: {
                vendors: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendor',
                    chunks: 'all'
                }
            }
        }

        config.plugins.push(
            new ManifestPlugin({
                fileName: 'manifest.json',
                basePath: paths.manifest,
                map: function (input) {
                    input.name = input.name.replace('/', '')
                    return input
                }
            })
        )
    }

    if (productionBuild) {
        config.devtool = ''
        config.mode = 'production'
        config.optimization.namedModules = false
        config.optimization.concatenateModules = true
        config.optimization.minimize = true
        config.optimization.minimizer = [
            new MinifyPlugin(
                {},
                {
                    comments: false
                }
            )
        ]

        const productionPlugins = [
            new webpack.HashedModuleIdsPlugin(),
            new webpack.BannerPlugin({
                banner: banner,
                raw: true,
                entryOnly: true
            })
            // new BundleAnalyzerPlugin()
        ]

        config.plugins = config.plugins.concat(productionPlugins)
    } else {
        const developmentPlugins = []

        config.plugins = config.plugins.concat(developmentPlugins)
    }

    return config
}

function compileJS (
    paths,
    filename,
    chunkName,
    productionBuild = false,
    logName = 'JS'
) {
    const webpackConfig = setupWebackConfig(
        paths,
        filename,
        chunkName,
        productionBuild
    )

    return function compileJS () {
        fancyLog(' ')
        fancyLog('-> Bundling ' + logName)

        return gulp
            .src(paths.src)
            .pipe(plumber({ errorHandler: onError }))
            .pipe(print())
            .pipe(
                webpackStream(webpackConfig, webpack, function (err) {
                    if (err) {
                        fancyLog.error(err)
                    }
                })
            )
            .pipe(size({ gzip: false, showFiles: true }))
            .pipe(gulp.dest(paths.dest))
    }
}

function jsDevMiddleware (paths, filename, reload) {
    const webpackConfig = setupWebackConfig(paths, filename, '', false, true)

    return WebpackDevMiddleware(webpack(webpackConfig), {
        publicPath: paths.public,
        reporter: function (middlewareOptions, options) {
            const { log, state, stats } = options

            if (state) {
                const displayStats = middlewareOptions.stats !== false

                if (displayStats) {
                    if (stats.hasErrors()) {
                        log.error(stats.toString(middlewareOptions.stats))
                    } else if (stats.hasWarnings()) {
                        log.warn(stats.toString(middlewareOptions.stats))
                    } else {
                        log.info(stats.toString(middlewareOptions.stats))
                    }
                }

                let message = 'Compiled successfully.'

                if (stats.hasErrors()) {
                    message = 'Failed to compile.'
                } else if (stats.hasWarnings()) {
                    message = 'Compiled with warnings.'
                }
                log.info(message)
            } else {
                log.info('Compiling...')
            }

            reload()
        }
    })
}

function cleanJS (paths, logName = 'js') {
    return function cleanJS (done) {
        fancyLog(' ')
        fancyLog('-> Cleaning ' + logName + ' folder')

        rimraf(paths.dest, done)
    }
}

module.exports = {
    compileJS,
    jsDevMiddleware,
    cleanJS
}
