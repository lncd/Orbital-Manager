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
			'base_url' => base_url(),
			'orbital_manager_name' => $this->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->config->item('orbital_core_location'),
			'page_title' => 'Welcome'
		);
	
		$this->parser->parse('includes/header', $data);
		$this->parser->parse('splash', $data);
		$this->parser->parse('includes/footer', $data);
	}
}

// End of file splash.php
// Location: ./controllers/splash.php