<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| JACAT Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
| See example and detailed explanation from:
| 	/application/config/jacat_example.php
*/

$jacat_ver = "?ver=0.4.20";

$config['jacat'] = array(

	// Site name
	'site_name' => 'Admin Panel',

	// Default page title prefix
	'page_title_prefix' => '',

	// Default page title
	'page_title' => '',

	// Default meta data
	'meta_data'	=> array(
		'author'		=> '',
		'description'	=> '',
		'keywords'		=> ''
	),

	// Default scripts to embed at page head or end
	'scripts' => array(
		'head'	=> array(
			'assets/dist/admin-lte/plugins/jquery/jquery.min.js' . $jacat_ver,
			'assets/dist/bootstrap/dist/js/bootstrap.bundle.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables/jquery.dataTables.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-select/js/select.bootstrap4.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/jszip/jszip.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/pdfmake/pdfmake.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/moment/moment-with-locales.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js'. $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-buttons/js/buttons.print.min.js' . $jacat_ver,
			'assets/dist/bootbox.js/dist/bootbox.all.min.js' . $jacat_ver,
		),
		'foot'	=> array(
			'assets/dist/admin-lte/dist/js/adminlte.min.js' . $jacat_ver,
		),
	),

	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'assets/dist/admin-lte/dist/css/adminlte.min.css' . $jacat_ver,
			'assets/dist/admin-lte/plugins/fontawesome-free/css/all.min.css' . $jacat_ver,
			'assets/dist/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css' . $jacat_ver,
			'assets/dist/ionicons/docs/css/ionicons.min.css' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-select/css/select.bootstrap4.min.css' . $jacat_ver,
			'assets/dist/admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css' . $jacat_ver,
			'assets/dist/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' . $jacat_ver
		)
	),

	// Default CSS class 
	'body_class' => 'sidebar-mini',
	'navbar_class' => 'navbar-white navbar-light',
	'navmenu_bg' => '',
	'side_style' => '',
	'aside_style' => 'sidebar-dark-info',
	'footer_style' => '',

	// Language files to autoload
	'language_files' => array('auth', 'ion_auth', 'general'),

	// Manual Multilingual (empty means browser sensitive autoswitch)
	'languages' => array(),

	// Menu items
	'menu' => array(
		'home' => array(
			'name'		=> 'Home',
			'url'		=> '',
			'icon'		=> 'fas fa-home',
		),
		'user' => array(
			'name'		=> 'Users',
			'url'		=> 'user',
			'icon'		=> 'fas fa-users',
			'children'  => array(
				'List'			=> 'user',
				'Create'		=> 'user/create',
				'User Groups'	=> 'user/group',
			)
		),
		'panel' => array(
			'name'		=> 'Admin Panel',
			'url'		=> 'panel',
			'icon'		=> 'fas fa-cog',
			'children'  => array(
				'Admin Users'			=> 'panel/admin_user:fa fa-cogs',
				'Create Admin User'		=> 'panel/admin_user_create',
				'Admin User Groups'		=> 'panel/admin_user_group',
			)
		),
		'util' => array(
			'name'		=> 'Utilities',
			'url'		=> 'util',
			'icon'		=> 'fas fa-cogs',
			'children'  => array(
				'Database Versions'		=> 'util/list_db',
			)
		),
		'logout' => array(
			'name'		=> 'Sign Out',
			'url'		=> 'panel/logout',
			'icon'		=> 'fas fa-sign-out-alt',
		)
	),

	// Login page
	'login_url' => '/admin/login',

	// Restricted pages
	'page_auth' => array(
		'user/create'				=> array('webmaster', 'admin', 'manager'),
		'user/group'				=> array('webmaster', 'admin', 'manager'),
		'panel'						=> array('webmaster'),
		'panel/admin_user'			=> array('webmaster'),
		'panel/admin_user_create'	=> array('webmaster'),
		'panel/admin_user_group'	=> array('webmaster'),
		'util'						=> array('webmaster'),
		'util/list_db'				=> array('webmaster'),
		'util/backup_db'			=> array('webmaster'),
		'util/restore_db'			=> array('webmaster'),
		'util/remove_db'			=> array('webmaster'),
	),

	// AdminLTE settings
	'adminlte' => array(
		'navbar_class' => array(
			'webmaster'	=> 'navbar-dark navbar-danger',
			'admin'		=> 'navbar-white navbar-warning',
			'manager'	=> 'navbar-white navbar-light',
			'staff'		=> 'navbar-white navbar-light',
		),
		'navmenu_bg' => array(
			'webmaster'	=> '',
			'admin'		=> '',
			'manager'	=> '',
			'staff'		=> '',
		),
		'side_class' => array(
			'webmaster'	=> '',
			'admin'		=> '',
			'manager'	=> '',
			'staff'		=> '',
		),
		'aside_class' => array(
			'webmaster'	=> 'sidebar-dark-danger',
			'admin'		=> 'sidebar-dark-warning',
			'manager'	=> 'sidebar-dark-purple',
			'staff'		=> 'sidebar-dark-purple',
		),
		'footer_class' => array(
			'webmaster'	=> '',
			'admin'		=> '',
			'manager'	=> '',
			'staff'		=> '',
		)
	),

	// Useful links to display at bottom of sidemenu
	'useful_links' => array(
		array(
			'auth'		=> array('webmaster', 'admin', 'manager', 'staff'),
			'name'		=> 'Frontend Website',
			'url'		=> '',
			'target'	=> '_blank',
			'color'		=> 'text-info'
		),
		array(
			'auth'		=> array('webmaster', 'admin'),
			'name'		=> 'API Site',
			'url'		=> 'api',
			'target'	=> '_blank',
			'color'		=> 'text-orange'
		),
		array(
			'auth'		=> array('webmaster', 'admin', 'manager', 'staff'),
			'name'		=> 'Github Repo',
			'url'		=> JACAT_REPO,
			'target'	=> '_blank',
			'color'		=> 'text-green'
		),
	),

	// Debug tools
	'debug' => array(
		'view_data'	=> FALSE,
		'profiler'	=> FALSE
	),
);

/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_admin';
