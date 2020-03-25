<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

$jacat_ver = "?ver=0.5.1";


$config['jacat'] = array(

	// Site name
	'site_name' => 'JACAT',

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
		),
		'foot'	=> array(
			'/assets/dist/admin-lte/plugins/jquery/jquery.min.js' . $jacat_ver,
			'/assets/dist/bootstrap/dist/js/bootstrap.bundle.min.js' . $jacat_ver,
			'/assets/dist/admin-lte/dist/js/adminlte.min.js' . $jacat_ver,
		),
	),

	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'/assets/dist/admin-lte/dist/css/adminlte.min.css' . $jacat_ver,
			'/assets/dist/admin-lte/plugins/fontawesome-free/css/all.min.css' . $jacat_ver,
			'/assets/dist/admin-lte//plugins/icheck-bootstrap/icheck-bootstrap.min.css'. $jacat_ver,
			'/assets/dist/ionicons/docs/css/ionicons.min.css' . $jacat_ver,
		)
	),

	// Default CSS class for <body> tag
	'body_class' => 'sidebar-mini hold-transition layout-top-nav',
	'navbar_class' => 'navbar navbar-expand navbar-dark',
	'navmenu_bg' => 'bg-dark',
	'side_class' => '',
	'aside_class' => '',
	'footer_style' => 'bg-dark',

	// language files to autoload
	'language_files' => array('auth', 'ion_auth', 'general'),
	
	// Multilingual settings
	'languages' => array(
		'default'		=> 'en',
		'available'		=> array(
			'en' => array(
				'label'	=> 'English',
				'value'	=> 'english'
			),
			'fr' => array(
				'label'	=> 'Français',
				'value'	=> 'french'
			),
			'it' => array(
				'label'	=> 'Italiano',
				'value'	=> 'italian'
			),
			'es' => array(
				'label'	=> 'Español',
				'value' => 'spanish'
			),
			'zh' => array(
				'label'	=> '繁體中文',
				'value'	=> 'traditional-chinese'
			),
			'cn' => array(
				'label'	=> '简体中文',
				'value'	=> 'simplified-chinese'
			)
		)
	),

	// Google Analytics User ID
	'ga_id' => '',

	// Menu items
	'menu' => array(
		'home' => array(
			'name'		=> 'Home',
			'url'		=> '',
		),
	),

	// Login page
	'login_url' => '',

	// Restricted pages
	'page_auth' => array(
	),

	// Email config
	'email' => array(
		'from_email'		=> '',
		'from_name'			=> '',
		'subject_prefix'	=> '',
		
		// Mailgun HTTP API
		'mailgun_api'		=> array(
			'domain'			=> '',
			'private_api_key'	=> ''
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
$config['sess_cookie_name'] = 'ci_session_frontend';
