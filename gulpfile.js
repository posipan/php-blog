const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');

gulp.task('default', function () {
  return gulp.watch('./html/assets/sass/**/*.scss', function () {
    return gulp
      .src('./html/assets/sass/style.scss')
      .pipe(sourcemaps.init())
      .pipe(
        sass({
          outputStyle: 'expanded',
        }).on('error', sass.logError)
      )
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('./html/assets/css'));
  });
});
