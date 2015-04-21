
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
        tasks: ['jshint', 'concat'],
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
            'framework/assets/js/lib/Base64.js',
            'framework/assets/js/src/ddpProperties.js'
          ],
          'framework/assets/js/ddpPropertyAdmin.js': [
            'framework/assets/js/lib/metabox-geocode.jquery.js',
            'framework/assets/js/src/ddpPropertyAdmin.js'
          ],
        },
      },
    },

    uglify: {
      my_target: {
        files: {
          'framework/assets/js/ddpProperties.js': ['framework/assets/js/ddpProperties.js'],
          'framework/assets/js/ddpPropertyAdmin.js': ['framework/assets/js/ddpPropertyAdmin.js']
        }
      }
    },

    jshint: {
      options: {
        /*
         * ENVIRONMENTS
         * =================
         */

        // Define globals exposed by modern browsers.
        "browser": true,

        // Define globals exposed by jQuery.
        "jquery": true,

        // Define globals exposed by Node.js.
        "node": true,

        /*
         * ENFORCING OPTIONS
         * =================
         */

        // Force all variable names to use either camelCase style or UPPER_CASE
        // with underscores.
        "camelcase": true,

        // Prohibit use of == and != in favor of === and !==.
        "eqeqeq": true,

        // Enforce tab width of 2 spaces.
        "indent": 2,

        // Prohibit use of a variable before it is defined.
        "latedef": true,

        // Enforce line length to 80 characters
        //"maxlen": 80,

        // Require capitalized names for constructor functions.
        "newcap": true,

        // Enforce use of single quotation marks for strings.
        "quotmark": "single",

        // Enforce placing 'use strict' at the top function scope
        "strict": true,

        // Prohibit use of explicitly undeclared variables.
        "undef": true,

        // Warn when variables are defined but never used.clear
        "unused": true,

        /*
         * RELAXING OPTIONS
         * =================
         */

        // Suppress warnings about == null comparisons.
        "eqnull": true,

        "loopfunc": true
      },
      files: [
        'framework/assets/js/src/*'
      ]
    }
  });

  grunt.registerTask('default', ['sass']);
  grunt.registerTask('compile', ['sass', 'jshint', 'concat', 'uglify']);
  grunt.registerTask('js', ['jshint', 'concat']);
};