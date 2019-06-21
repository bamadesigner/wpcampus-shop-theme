const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const gulp = require('gulp');
const mergeMediaQueries = require('gulp-merge-media-queries');
const notify = require('gulp-notify');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const shell = require('gulp-shell');

// Define the source paths for each file type.
const src = {
	php: ['**/*.php','!vendor/**','!node_modules/**'],
	css: ['assets/css/src/**/*']
};

// Define the destination paths for each file type.
const dest = {
	css: 'assets/css'
};

// Take care of CSS.
gulp.task('css', function() {
	return gulp.src(src.css)
		.pipe(sass({
			outputStyle: 'expanded'
		}).on('error', sass.logError))
		.pipe(mergeMediaQueries())
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(cleanCSS({
			compatibility: 'ie8'
		}))
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest(dest.css))
		.pipe(notify('WPC Shop CSS compiled'));
});

// "Sniff" our PHP.
gulp.task('php', function() {
	// TODO: Clean up. Want to run command and show notify for sniff errors.
	return gulp.src('functions.php', {read: false})
		.pipe(shell(['composer sniff'], {
			ignoreErrors: true,
			verbose: false
		}))
		.pipe(notify('WPC Shop PHP sniffed'), {
			onLast: true,
			emitError: true
		});
});

// Test our files.
gulp.task('test',['php']);

// Compile all the things.
gulp.task('compile',['css']);

// I've got my eyes on you(r file changes).
gulp.task('watch',['default'],function() {
	gulp.watch(src.php,['php']);
	gulp.watch(src.css,['css']);
});

// Let's get this party started.
gulp.task('default',['compile','test']);