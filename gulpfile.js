const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const gulp = require('gulp');
const mergeMediaQueries = require('gulp-merge-media-queries');
const notify = require('gulp-notify');
const rename = require('gulp-rename');
const sass = require('gulp-sass');

// Define the source paths for each file type.
const src = {
	css: ['assets/css/src/**/*']
};

// Define the destination paths for each file type.
const dest = {
	css: 'assets/css'
};

// Take care of CSS.
gulp.task('css', function( done ) {
	return gulp.src(src.css)
		.pipe(sass({
			outputStyle: 'expanded'
		}).on('error', sass.logError))
		.pipe(mergeMediaQueries())
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(cleanCSS({
			compatibility: 'ie8'
		}))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest(dest.css))
		.pipe(notify('WPC Shop SASS compiled'))
		.on('end', done);
});

// Compile all the things.
gulp.task('compile', gulp.series('css'));

// Let's get this party started.
gulp.task('default', gulp.series('compile'));

// I've got my eyes on you(r file changes).
gulp.task('watch', gulp.series('default', function( done ) {
	gulp.watch(src.css, gulp.series('css'));
	return done();
}));