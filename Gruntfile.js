module.exports = function(grunt) {
    // Configuration de Grunt
    grunt.initConfig({
        autoprefixer: {
            options: {
                browsers: ['last 5 versions', '> 0.2%']
            },
            dist: {
                expand: true,
                flatten: true,
                cwd: "controller/css/",
                src: ["*.css"],
                dest: "controller/css/",
            },
        },
        compass: {
            dist: {
              options: {
                sassDir: 'controller/sass',
                cssDir: 'controller/css',
                outputStyle: 'compressed',
                force: true,
              }
            }
        },
    });

    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-compass');
  
    // Définition des tâches Grunt
    grunt.registerTask("dev", ['compass', 'autoprefixer']);
  };