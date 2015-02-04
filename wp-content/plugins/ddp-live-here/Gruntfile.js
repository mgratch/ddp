
module.exports = function (grunt) {
  // load all grunt tasks
  require('load-grunt-tasks')(grunt);

  grunt.initConfig({

    watch: {
      options: {
        livereload: true,
      },

      scripts: {
        files: ['framework/assets/js/**/*.js'],
        tasks: ['concat'],
        options: {
          spawn: false,
        },
      },

      css: {
        files: ['framework/assets/css/sass/partials/*.scss'],
        tasks: ['sass', 'autoprefixer'],
        options: {
          spawn: false,
        },
      }
    },

    sass: {
      dist: {
        options: {
          style: 'expanded',
          lineNumbers: true
        },
        files: {
          'framework/assets/css/style.css': 'framework/assets/css/sass/style.scss',
        }
      }
    },

    autoprefixer: {
      options: {
        browsers: ['last 2 version', 'ie 8', 'ie 9']
      },

      multiple_files: {
        expand: true,
        flatten: true,
        src: 'css/style.css', // -> src/css/file1.css, src/css/file2.css
        dest: 'css/' // -> dest/css/file1.css, dest/css/file2.css
      }
    },

    concat: {
      basic_and_extras: {
        files: {
          'framework/assets/js/ddpProperties.js': [
            'framework/assets/js/lib/jquery.bxslider.min.js',
            'framework/assets/js/lib/gmaps.min.js',
            'framework/assets/js/lib/numeral.min.js',
            'framework/assets/js/src/ddpProperties.js'
          ],
        },
      },
    }
  });

  grunt.registerTask('default', ['sass']);
  grunt.registerTask('compile', ['sass']);
  grunt.registerTask('js', ['concat']);
};