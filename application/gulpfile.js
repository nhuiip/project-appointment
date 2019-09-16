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

//var theme = "canvas";
var theme = "inspinia";

gulp.task('connect-sync', function() {
  connect.server({}, function (){
    browserSync({
      proxy: '127.0.0.1:8000',
      port: 9000
    });
  });
  gulp.watch('**/*.php').on('change', function () {
    browserSync.reload();
  });
});

gulp.task('images', () =>
	gulp.src('assets/'+theme+'/images/*')
		.pipe(imagemin())
		.pipe(gulp.dest('assets/'+theme+'/images/img'))
);

/* ########### Inspinia theme ###########*/
gulp.task('scss-inspinia', function () {
  gulp.src('assets/'+theme+'/scss/*.scss')
      .pipe(sass().on('error', sass.logError))
      .pipe(minifyCSS())  // สั่ง execute minifyCSS
      .pipe(rename({ suffix: '.min' }))   // หลังจาก minify ก็เพิ่ม .min ต่อท้ายชื่อไฟล์
      .pipe(gulp.dest('assets/'+theme+'/css/'))
});

gulp.task('js-inspinia', function() {
    return gulp
        .src('assets/'+theme+'/js/methods/app/**/*.js')         // ไฟล์ที่ต้องการ uglify()
        .pipe(uglify())         // สั่ง execute uglify()
        .pipe(rename({ suffix: '.min' }))   // เพิ่ม .min ต่อท้ายไฟล์
        .pipe(gulp.dest('assets/'+theme+'/js/methods'));     // โฟลเดอร์ที่ต้องการเซฟ
});
/* ########### End inspinia theme ###########*/

/* ########### Canvas theme ###########*/
gulp.task('scss-canvas', function () {
  gulp.src('assets/'+theme+'/style.scss')
      .pipe(sass().on('error', sass.logError))
      .pipe(minifyCSS())  // สั่ง execute minifyCSS
      .pipe(rename({ suffix: '.min' }))   // หลังจาก minify ก็เพิ่ม .min ต่อท้ายชื่อไฟล์
      .pipe(gulp.dest('assets/'+theme+'/'))
});

gulp.task('js-canvas', function() {
    return gulp
        .src('assets/'+theme+'/js/methods/app/**/*.js') // ไฟล์ที่ต้องการ uglify()
        .pipe(uglify()) // สั่ง execute uglify()
        .pipe(rename({ suffix: '.min' })) // เพิ่ม .min ต่อท้ายไฟล์
        .pipe(gulp.dest('assets/'+theme+'/js/methods')); // โฟลเดอร์ที่ต้องการเซฟ
});
/* ########### End canvas theme ###########*/

if(theme == "inspinia"){

  gulp.task('default', ['connect-sync','scss-inspinia','js-inspinia','images'], function () {
      gulp.watch(['**/*.php'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/css/**/*.css'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/js/**/*.js'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/images/img/*'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/images/*'], ['images']);
      gulp.watch('assets/'+theme+'/scss/**/*.scss', ['scss-inspinia']);
      gulp.watch(['assets/'+theme+'/js/methods/app/**/*.js'], ['js-inspinia']);
  });

}else if(theme == "canvas"){

  gulp.task('default', ['connect-sync','scss-canvas','js-canvas','images'], function () {
      gulp.watch(['**/*.php'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/css/**/*.css'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/js/**/*.js'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/images/img/*'], browserSync.reload);
      gulp.watch(['assets/'+theme+'/images/*'], ['images']);
      gulp.watch('assets/'+theme+'/sass/**/*.scss', ['scss-canvas']);
      gulp.watch(['assets/'+theme+'/js/methods/app/**/*.js'], ['js-canvas']);
  });

}
