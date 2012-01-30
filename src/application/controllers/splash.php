<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Splash extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
	
		$data = array(
			'page_title' = 'Welcome to ' . $this->config->item('orbital_manager_name')
		);
	
		$this->parser->parse('includes/header', $data);
		$this->load->view('splash', $data);
		$this->load->view('includes/footer');
	}
}

// EOF