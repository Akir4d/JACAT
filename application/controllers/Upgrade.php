<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration Upgrade if you want to reset
 */
class Upgrade extends MX_Controller {

	public function index()
	{
		$this->load->model('migration');
		$this->migration->check_migration();
		redirect('/');
	}

	public function reset(){
		// Dangerous Disabled by default
		//$this->load->model('migration');
		//$this->migration->check_migration(true);
		redirect('/');
	}
}
