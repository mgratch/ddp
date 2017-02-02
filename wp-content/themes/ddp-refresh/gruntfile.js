module.exports = function (grunt) {
  // load all grunt tasks
  require('load-grunt-tasks')(grunt);

  grunt.initConfig({

    watch: {
      options: {
        livereload: true,
      },

      scripts: {
        files: ['javascript/*.js'],
        tasks: [],
        options: {
          spawn: false,
        },
      },

      css: {
        files: ['css/sass/partials/*.scss'],
        tasks: ['sass', 'autoprefixer'],
        options: {
          spawn: false,
        },
      }
    },

    sass: {
      options: {
        sourceMap: true,
        outputStyle: 'expanded',
        sourceComments: true
      },
      dist: {
        files: {
          'css/style.css': 'css/sass/style.scss',
          'css/style-ie.css': 'css/sass/style-ie.scss'
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

    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'css',
          src: ['*.css', '!*.min.css'],
          dest: 'css',
          ext: '.min.css'
        }]
      }
    }

  });

  grunt.registerTask('default', ['compile', 'watch']);
  grunt.registerTask('compile', ['sass', 'autoprefixer']);
  grunt.registerTask('deploy', ['sass', 'autoprefixer', 'cssmin']);
};