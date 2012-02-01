<?php

/**
 * Static Page Controller
 *
 * Loads view templates for static page content.
 *
 * @category   Controller
 * @package    Orbital
 * @subpackage Manager
 * @author     Nick Jackson <nijackson@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Static_Content
*/

class Static_Content extends CI_Controller {

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
	 * Default home page
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
		$this->parser->parse('static/home', $data);
		$this->parser->parse('includes/footer', $data);
	}
	
	/**
	 * About
	 *
	 * Page explaining more about Orbital Manager and Orbital Core.
	*/
	
	function about()
	{
	
		$data = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $this->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->config->item('orbital_core_location'),
			'page_title' => 'About'
		);
	
		$this->parser->parse('includes/header', $data);
		$this->parser->parse('static/about', $data);
		$this->parser->parse('includes/footer', $data);
	}
	
	/**
	 * Contact
	 *
	 * Page explaining how to contact people about Orbital.
	*/
	
	function contact()
	{
	
		$data = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $this->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->config->item('orbital_core_location'),
			'page_title' => 'Contact'
		);
	
		$this->parser->parse('includes/header', $data);
		$this->parser->parse('static/contact', $data);
		$this->parser->parse('includes/footer', $data);
	}
	
}

// End of file static.php
// Location: ./controllers/static.php