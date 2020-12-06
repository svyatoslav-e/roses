module.exports = function(grunt) {
	grunt.initConfig({
		sass: {
			dist: {
				files: {
					'catalog/view/theme/vuetyshop/stylesheet/style.css' : 'catalog/view/theme/vuetyshop/stylesheet/style.scss'
				}
			}
		},
		watch: {
			css: {
				files: '**/*.scss',
				tasks: ['sass']
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default',['watch']);
};