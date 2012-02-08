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

	private $data = array();

	/**
	 * Constructor
	*/

	function __construct()
	{
		parent::__construct();
		
		$this->data = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $this->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->config->item('orbital_core_location')
		);
		
		if ($this->session->userdata('current_user_name'))
		{
			$this->data['user_presence'] = 'Signed in as <a href="#">' . $this->session->userdata('current_user_name') . '</a>';
		}
		else
		{
			$this->data['user_presence'] = '<a href="#">Sign In</a>';
		}
	}

	/**
	 * Index
	 *
	 * Default home page
	*/

	function index()
	{
	
		
		$this->data['page_title'] = 'Welcome';
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('static/home', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
	
	/**
	 * About
	 *
	 * Page explaining more about Orbital Manager and Orbital Core.
	*/
	
	function about()
	{
	
		$this->data['page_title'] = 'About';
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('static/about', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
	
	/**
	 * Contact
	 *
	 * Page explaining how to contact people about Orbital.
	*/
	
	function contact()
	{
	
		$this->data['page_title'] = 'Contact';
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('static/contact', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
	
}

// End of file static.php
// Location: ./controllers/static.php