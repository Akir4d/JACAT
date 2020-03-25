/**
 * Gulp configuration file
 */

// basic paths
var dir_bower = './bower_components',	// folder with Bower packages
	dir_src = './src',					// folder for non-public source scripts, stylesheets, pre-processed images, etc.
	dir_asset = './assets',				// folder for public assets
	dir_dist = dir_asset + '/dist',		// destination for post-processed scripts, stylesheets and images
	dir_theme = dir_src + '/theme';		// default folder for theme files

module.exports = {
	
	// Task: clean up destination folder
	// Plugin: del (https://github.com/sindresorhus/del)
	clean: {
		src: [
			dir_dist + "**/*",
			"!" + dir_dist + "/index.html"
		]
	},

	// Task: copy required files & folders to destination folder
	copy: {
		src: {
			// Font files from Bower packages
			/*
			fonts: [
				dir_bower + '/bootstrap/dist/fonts/**',
				dir_bower + '/font-awesome/fonts/**',
				dir_bower + '/Ionicons/fonts/**'
			],
			*/
			// Files (JS / CSS / etc.) directly copy to destination folder.
			
			files: [
				dir_bower + '/**',
				//Github pages compatibility
				"!" + dir_bower + '/**/*.html',
				"!" + dir_bower + '/**/*.md',
			]
		},
		dest: {
			//fonts: dir_dist + '/fonts',
			files: dir_dist
		}
	},

	/*
	// Task: concat and minify CSS files
	// Plugin: gulp-clean-css (https://github.com/scniro/gulp-clean-css)
	cssmin: {
		src: {
			// Frontend Website - 3rd party libraries
			frontend_lib: [
				dir_bower + '/bootstrap/dist/css/bootstrap.min.css',
				dir_bower + '/font-awesome/css/font-awesome.min.css',
			],
			// Admin Panel - AdminLTE theme
			adminlte: [
				dir_bower + '/bootstrap/dist/css/bootstrap.min.css',
				dir_bower + '/jquery-ui-bootstrap/assets/css/bootstrap.min.css',
				dir_bower + '/admin-lte/plugins/pace/pace.min.css',
				dir_bower + '/admin-lte/dist/css/AdminLTE.min.css',
				dir_bower + '/admin-lte/dist/css/skins/_all-skins.min.css'
			],
			// Admin Panel - 3rd party libraries
			admin_lib: [
				dir_bower + '/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css',
				dir_bower + '/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
				dir_bower + '/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
				dir_bower + '/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
				dir_bower + '/font-awesome/css/font-awesome.min.css',
				dir_bower + '/Ionicons/css/ionicons.min.css',
				dir_bower + '/spectrum/spectrum.css',
				dir_bower + '/select2/dist/css/select2.min.css',
				dir_bower + '/Flot/examples/shared/jquery-ui/jquery-ui.min.css',
				dir_bower + '/ion.rangeSlider/css/ion.rangeSlider.min.css',
				dir_bower + '/fullcalendar/dist/fullcalendar.print.min.css',
				dir_bower + '/fullcalendar/dist/fullcalendar.min.css',
				dir_bower + '/datatables.net-select-bs/css/select.bootstrap.min.css',
				dir_bower + '/datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
				dir_bower + '/datatables.net-bs/css/dataTables.bootstrap.min.css'
			]
		},
		dest: {
			frontend: 	dir_dist + '/frontend',
			admin: 		dir_dist + '/admin'
		},
		dest_file: {
			frontend_lib: 	'lib.min.css',
			adminlte: 		'adminlte.min.css',
			admin_lib: 		'lib.min.css'
		},
		options: {
			advanced: true,	// set "false" for faster operation, but slightly larger output files
			keepSpecialComments: 0
		}
	},

	// Task: compile SASS files (and concat with CSS files)
	// Plugin: gulp-sass (https://github.com/dlmanning/gulp-sass)
	sass: {
		src: {
			// Frontend Website
			frontend: [
				// Main SASS file
				dir_src + '/sass/frontend.scss',

				// Bootstrap examples (http://getbootstrap.com/getting-started/#examples)
				// Comment this to remove preset styles
				//dir_src + '/css/bootstrap-examples/sticky-footer-navbar.css',

				// Custom CSS file
				dir_src + '/css/frontend.css'
			],
			// Admin Panel
			admin: [
				// Main SASS file
				dir_src + '/sass/admin.scss',

				// Custom CSS file
				dir_src + '/css/admin.css'
			]
		},
		dest: {
			frontend: 	dir_dist + '/frontend',
			admin: 		dir_dist + '/admin'
		},
		dest_file: {
			frontend: 	'app.min.css',
			admin: 		'app.min.css'
		},
		options: {
			outputStyle: 'compressed'
		}
	},

	// Task: concat and minify (uglify) JS files
	// Plugin: gulp-uglify (https://github.com/terinjokes/gulp-uglify)
	uglify: {
		src: {
			// Frontend Website - 3rd party libraries
			frontend_lib: [
				dir_bower + '/jquery/dist/jquery.min.js',
				dir_bower + '/bootstrap/dist/js/bootstrap.min.js',
			],
			// Frontend Website - custom scripts
			frontend: [
				dir_src + '/js/frontend.js'
			],
			// Admin Panel - AdminLTE theme
			adminlte: [
				// use jQuery 1.x for compatibility with Grocery CRUD
				dir_bower + '/jquery/dist/jquery.min.js',
				dir_bower + '/jquery-ui/jquery-ui.min.js',
				dir_bower + '/bootstrap/dist/js/bootstrap.min.js',
				dir_bower + '/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
				dir_bower + '/admin-lte/plugins/iCheck/icheck.min.js',
				dir_bower + '/admin-lte/plugins/pace/pace.min.js',
				dir_bower + '/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
				dir_bower + '/admin-lte/dist/js/adminlte.min.js'
				
				// include other plugins below when necessary
			],
			// Admin Panel - 3rd party libraries
			admin_lib: [
				dir_bower + '/fastclick/lib/fastclick.js',
				dir_bower + '/slimScroll/jquery.slimscroll.min.js',
				dir_bower + '/Sortable/Sortable.min.js',
				dir_bower + '/spectrum/spectrum.js',
				dir_bower + '/bootbox.js/dist/bootbox.all.min.js',
				dir_bower + '/select2/dist/js/select2.full.min.js',
				dir_bower + '/datatables.net/js/jquery.dataTables.min.js',
				dir_bower + '/datatables.net-select/js/dataTables.select.min.js',
				dir_bower + '/datatables.net-bs/js/dataTables.bootstrap.min.js',
				dir_bower + '/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
				dir_bower + '/jquery-ui-bootstrap/assets/js/vendor/jquery-ui-1.10.3.custom.min.js',
				dir_bower + '/morris.js/morris.min.js',
				dir_bower + '/moment/min/moment.min.js',
				dir_bower + '/moment/min/locales.min.js',
				dir_bower + '/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
				dir_bower + '/jszip/dist/jszip.min.js',
				dir_bower + '/pdfmake/build/pdfmake.min.js',
				dir_bower + '/datatables.net-buttons/js/dataTables.buttons.min.js',
				dir_bower + '/datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
				dir_bower + '/datatables.net-buttons/js/buttons.html5.min.js',
				dir_bower + '/datatables.net-buttons/js/buttons.print.min.js'
				
			],
			// Admin Panel - custom scripts
			admin: [
				dir_src + '/js/admin.js'
			]
		},
		dest: {
			frontend: 		dir_dist + '/frontend',
			admin: 			dir_dist + '/admin'
		},
		dest_file: {
			frontend_lib: 	'lib.min.js',
			frontend: 		'app.min.js',
			adminlte: 		'adminlte.min.js',
			admin_lib:		'lib.min.js',
			admin: 			'app.min.js',
		},
		options: {
		}
	},
	*/
	// Tasks: optimize images
	// Plugin: gulp-imagemin (https://github.com/sindresorhus/gulp-imagemin)
	imagemin: {
		src: dir_src + "/images/**/*.{png,jpg,gif,svg}",
		dest: dir_dist + "/images",
		options: {
		}
	}
};
