module.exports = function(grunt) {
    grunt.initConfig({
      sass: {
        dist: {
          options: {
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
          files: "js/*.js",
          tasks: ["scripts:dev"],
        },
        styles: {
          files: "sass/*.scss",
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
      compass: {
        dist: {
          options: {
            config: 'config.rb'
          }
        }
      }
    });
  
    grunt.loadNpmTasks("grunt-contrib-sass");
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-compass');
  
    grunt.registerTask("dev", ["compass", 'postcss:dist']);
    grunt.registerTask("test", ["compass"]);
    grunt.registerTask("default", ["test", 'watch']);
  };  