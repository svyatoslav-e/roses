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
			},
		},
		cssmin: {
			css: {
				files: {
					'catalog/view/theme/vuetyshop/stylesheet/style.min.css' : 'catalog/view/theme/vuetyshop/stylesheet/style.css'
				}
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.registerTask('default',['watch', 'cssmin']);
};