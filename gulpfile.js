//var elixir = require('laravel-elixir');
var gulp =require('gulp');
var browser=require('browser-sync');
var less=require('gulp-less');
var LessPluginAutoPrefix = require('less-plugin-autoprefix');
var autoprefix = new LessPluginAutoPrefix({ browsers: ['last 5 versions'] });

var postcss      = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var vueify=require('gulp-vueify');
var browserify=require('gulp-browserify');
var concat=require('gulp-concat');


var cleancss=require('gulp-clean-css');

var minjs=require('gulp-js-minify');

//const components = require('gulp-single-file-components');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
/*
elixir(function(mix) {
    mix.sass('app.scss');
});
*/


gulp.task('vueify',function () {
    return gulp.src('public/static/js/webpack/*.js')
        .pipe(browserify({
            transform:[
                'gulp-vueify'
            ]
        }))

        .pipe(gulp.dest('public/static/js/build/'));
})

gulp.task('minjs',function () {
    return gulp.src('public/static/maxjs/*.js')
        .pipe(minjs())
        .pipe(gulp.dest('public/static/js/'));
});
gulp.task('minjs_admin',function () {
    return gulp.src('public/static/maxjs/admin/*.js')
        .pipe(minjs())
        .pipe(gulp.dest('public/static/js/admin'));
});



gulp.task('minjs2',function () {
    return gulp.src('public/static/maxjs/vue/*.js')
        .pipe(minjs())
        .pipe(gulp.dest('public/static/js/vue/'));
});

gulp.task('less',function(){
   return gulp.src('./resources/assets/*.less')
       .pipe(less({
           plugins: [autoprefix]
       }))
        .pipe(gulp.dest('./public/static/css'));
});
gulp.task('less2',function(){
    gulp.src('public/static/less/*.less')
        .pipe(less({
           // plugins: [autoprefix]
        }))

        .pipe(postcss([ autoprefixer() ]))
        .pipe(cleancss({compatibility: 'ie8'}))
        .pipe(gulp.dest('public/static/css'))

        .pipe(browser.stream());
});


gulp.task('serve',['less','less2'],function(){
    browser.init({
        open: 'external',
        host: 'timka.local',
        proxy: 'timka.local',
        port: 8080
    });
    gulp.watch("resources/assets/*.less",['less']);
    gulp.watch("public/static/less/*.less",['less2']);
    gulp.watch("public/*.php").on('change',browser.reload);
});
gulp.task('default',['serve']);