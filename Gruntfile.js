module.exports = function(grunt){

	grunt.initConfig({
		concat: {
			options: {
				separator: ';',
			},
			dist: {
				src: [
					'public/js/jquery/jquery.js',
					'public/js/superfish/superfish.js',
					'public/js/owl/owl.carousel.min.js',
					'public/js/lightbox/lightbox.js',
					'public/js/sticky.js',
					'public/js/rating.js',
					'public/js/app.js',
				],
				dest: 'public/js/app_min.js',
			},
		},

		uglify: {
			dist: {
				files: {
					'public/js/app_min.js': ['public/js/app_min.js']
				}
			}
		}
	});	

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('default',['concat','uglify']);

}