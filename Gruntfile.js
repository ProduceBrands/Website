module.exports = function (grunt) {
	// load all deps
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// configuration
	grunt.initConfig({
		pgk: grunt.file.readJSON('package.json'),

		// https://npmjs.org/package/grunt-contrib-compass
		compass: {
			options: {
				sassDir:        'assets/lib',
				cssDir:         'assets/stylesheets',
				imagesDir:      'assets/images',
				outputStyle:    'compact',
				relativeAssets: true,
				noLineComments: true,
				importPath:     ['bower_components']
			},
			dev: {
				options: {
					watch: true
				}
			},
			build: {
				options: {
					watch: false,
					force: true
				}
			}
		},

		// Parse CSS and add vendor-prefixed CSS properties using the Can I Use database. Based on Autoprefixer.
		// https://github.com/nDmitry/grunt-autoprefixer
		autoprefixer: {
			dev: {
				files: [{
					expand: true,
					cwd:    'assets/stylesheets',
					src:    '*.css',
					dest:   'assets/stylesheets'
				}]
			},

			shortcodes: {
				files: [{
					expand: true,
					cwd:    'assets/shortcodes-ultimate-skins/organique',
					src:    '*.css',
					dest:   'assets/shortcodes-ultimate-skins/organique'
				}]
			}
		},

		// https://npmjs.org/package/grunt-contrib-watch
		watch: {
			options: {
				livereload: true,
				spawn:      false
			},

			// autoprefix the files
			autoprefixer: {
				files: ['assets/stylesheets/*.css'],
				tasks: ['autoprefixer:dev'],
			},

			// PHP
			other: {
				files: [ '**/*.php' ],
			},

			// JS
			js: {
				files: ['assets/js/src/*.js'],
				tasks: ['requirejs:build']
			}
		},

		// https://npmjs.org/package/grunt-concurrent
		concurrent: {
			server: [
				'compass:dev',
				'watch'
			]
		},

		// https://npmjs.org/package/grunt-contrib-jshint
		jshint: {
			dist: {
				jshintrc: true,
				files: {
					src: ['assets/js/custom.js', 'Gruntfile.js']
				}
			}
		},

		// requireJS optimizer
		// https://github.com/gruntjs/grunt-contrib-requirejs
		requirejs: {
			build: {
				// Options: https://github.com/jrburke/r.js/blob/master/build/example.build.js
				options: {
					baseUrl:                 '',
					mainConfigFile:          'assets/js/src/main.js',
					optimize:                'uglify2',
					preserveLicenseComments: false,
					useStrict:               true,
					wrap:                    true,
					name:                    'bower_components/almond/almond',
					include:                 'assets/js/src/main',
					out:                     'assets/js/dist/main.min.js'
				}
			}
		},
	});

	// when developing
	grunt.registerTask('server', [
		'concurrent:server'
	]);

	// linting
	grunt.registerTask('lint', ['jshint']);

	// defaults to the server
	grunt.registerTask('default', [
		'server'
	]);

	// build
	grunt.registerTask( 'build', [
		'compass:build',
		'autoprefixer:dev',
		'requirejs:build'
	] );
};