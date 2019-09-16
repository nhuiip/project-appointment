var gulp = require('gulp');
var connect = require('gulp-connect-php');
var browserSync = require('browser-sync');
var sass = require('gulp-sass');
var minifyCSS = require('gulp-minify-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var sourcemaps = require('gulp-sourcemaps');
var rjs = require('gulp-requirejs');

var theme = "inspinia";

gulp.task('connect-sync', function() {
  connect.server({}, function (){
    browserSync({
      proxy: '127.0.0.1:8000',
      port: 9900
    });
  });
  gulp.watch('**/*.php').on('change', function () {
    browserSync.reload();
  });
});

gulp.task('images', () =>
	gulp.src('assets/images/*')
		.pipe(imagemin())
		.pipe(gulp.dest('assets/images/img'))
);

/* ########### Inspinia theme ###########*/
gulp.task('scss-inspinia', function () {
  gulp.src('assets/scss/*.scss')
      .pipe(sass().on('error', sass.logError))
      .pipe(minifyCSS())  // สั่ง execute minifyCSS
      .pipe(rename({ suffix: '.min' }))   // หลังจาก minify ก็เพิ่ม .min ต่อท้ายชื่อไฟล์
      .pipe(gulp.dest('assets/css/'))
});

gulp.task('js-inspinia', function() {
    return gulp
        .src('assets/js/methods/app/**/*.js')         // ไฟล์ที่ต้องการ uglify()
        .pipe(uglify())         // สั่ง execute uglify()
        .pipe(rename({ suffix: '.min' }))   // เพิ่ม .min ต่อท้ายไฟล์
        .pipe(gulp.dest('assets/js/methods'));     // โฟลเดอร์ที่ต้องการเซฟ
});

if(theme == "inspinia"){

  gulp.task('default', ['connect-sync','scss-inspinia','js-inspinia','images'], function () {
      gulp.watch(['**/*.php'], browserSync.reload);
      gulp.watch(['assets/css/**/*.css'], browserSync.reload);
      gulp.watch(['assets/js/**/*.js'], browserSync.reload);
      gulp.watch(['assets/images/img/*'], browserSync.reload);
      gulp.watch(['assets/images/*'], ['images']);
      gulp.watch('assets/scss/**/*.scss', ['scss-inspinia']);
      gulp.watch(['assets/js/methods/app/**/*.js'], ['js-inspinia']);
  });

}
