<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class Static_Content extends CI_Controller {

	private $data = array();

	/**
	 * Constructor
	*/

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
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

// End of file static_content.php
// Location: ./controllers/static_content.php