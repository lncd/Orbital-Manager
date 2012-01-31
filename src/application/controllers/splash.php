<?php

/**
 * Splash Page
 *
 * Home page for users
 *
 * @category   Controller
 * @package    Orbital
 * @subpackage Manager
 * @author     Nick Jackson <nijackson@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Splash
*/

class Splash extends CI_Controller {

	/**
	 * Constructor
	*/

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Index
	 *
	 * Parses the splash template
	*/

	function index()
	{
	
		$data = array(
			'page_title' => 'Welcome to ' . $this->config->item('orbital_manager_name')
		);
	
		$this->parser->parse('includes/header', $data);
		$this->load->view('splash', $data);
		$this->load->view('includes/footer');
	}
}

// End of file splash.php
// Location: ./controllers/splash.php