'use strict';


var autoprefixer = require('gulp-autoprefixer');
var csso = require('gulp-csso');
var del = require('del');
var gulp = require('gulp');
var runSequence = require('run-sequence');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');

// Set the browser that you want to support
const AUTOPREFIXER_BROWSERS = [
  'ie >= 10',
  'ie_mob >= 10',
  'ff >= 30',
  'chrome >= 34',
  'safari >= 7',
  'opera >= 23',
  'ios >= 7',
  'android >= 4.4',
  'bb >= 10'
];


var paths = {
  dest: 'dist',
  destpath: './dist',
  dev : "./src/js",
  sass: {
    input: './src/sass/*.scss',
    output: './dist/css',
    watch: './src/sass/**/*.scss'
  },
  scripts: {
      input: './src/js/**/*.js',
      output: './dist/js'
  }
  
};

// Gulp task to minify CSS files
gulp.task('sass', function () {
  return gulp.src(paths.sass.input)
    // Compile SASS files
    .pipe(sass({
      outputStyle: 'nested',
      precision: 10,
      includePaths: ['.'],
      onError: console.error.bind(console, 'Sass error:')
    }))
    // Auto-prefix css styles for cross browser compatibility
    .pipe(autoprefixer({browsers: AUTOPREFIXER_BROWSERS}))
    // Minify the file
    .pipe(csso())
    // Output
    .pipe(gulp.dest(paths.sass.output))

});

// Gulp task to minify JavaScript files
gulp.task('scripts', function() {
  return gulp.src(paths.scripts.input)
    // Minify the file
    .pipe(uglify())
    // Output
    .pipe(gulp.dest(paths.scripts.output))
});

gulp.task('scripts-all', function() {

  var scripts = [
    // Start - All BS4 stuff
    paths.dev + '/bootstrap4/bootstrap.js',
    // End - All BS4 stuff
    paths.dev + '/skip-link-focus-fix.js',
    paths.dev + '/price-variation.js',
    // Adding currently empty javascript file to add on for your own themes´ customizations
    // Please add any customizations to this .js file only!
    paths.dev + '/custom-javascript.js'

  ];

  gulp.src( scripts )
    .pipe( concat( 'theme.min.js' ) )
    .pipe( uglify() )
    .pipe( gulp.dest( paths.scripts.output ) );
});




// Clean output directory
gulp.task('clean', () => del(['dist/css','dist/js']));

gulp.task('watch',['clean'],function () {
  
  gulp.watch(paths.sass.watch, ['sass']);
  gulp.watch(paths.scripts.input,['scripts-all']);

});
