module.exports = function(grunt) {
    grunt.initConfig({
      sass: {
        dist: {
          options: {
            sourcemap: "none",
            style: "expanded",
          },
          files: [
            {
              // C'est ici que l'on définit le dossier que l'on souhaite importer
              expand: true,
              cwd: "sass/",
              src: ["*.scss"],
              dest: "css/",
              ext: ".css",
            },
          ],
        },
      },
      watch: {
        scripts: {
          files: "**/*.js",
          tasks: ["scripts:dev"],
        },
        styles: {
          files: "**/*.scss",
          tasks: ["sass:dist"],
        },
      },
      postcss: {
        options: {
          map: false, // inline sourcemaps
          processors: [
            require('pixrem')(), // add fallbacks for rem units
            require('autoprefixer')({browsers: 'last 2 versions'}), // add vendor prefixes
            require('cssnano')() // minify the result
          ]
        },
        dist: {
          src: 'css/*.css'
        }
      },
    });
  
    grunt.loadNpmTasks("grunt-contrib-sass");
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
  
    grunt.registerTask("dev", ["sass:dist", 'postcss:dist']);
    grunt.registerTask("default", ["sass:dist", 'watch']);
  };  