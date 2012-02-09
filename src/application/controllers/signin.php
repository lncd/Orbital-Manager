<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sign In Controller
 *
 * Marshalls sign-in requests to the appropriate Core URI
 *
 * @category   Controller
 * @package    Orbital
 * @subpackage Manager
 * @author     Nick Jackson <nijackson@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
*/

class Signin extends CI_Controller {

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
	 * Sign In
	 *
	 * Directs user to sign-in method selection.
	*/

	function index()
	{
	
		$auth_types = $this->orbital->core_auth_types();
		
		foreach ($auth_types->response->auth_types as $auth_type)
		{
			$this->data['auth_types'][] = array(
				'name' => $auth_type->name,
				'uri' => $auth_type->uri
			);
		}
		
		$this->data['page_title'] = 'Sign In';
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('user/signin', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
	
	/**
	 * Sign Out
	 *
	 * Destroys user session and redirects to home page.
	*/
	
	function signout()
	{
		$this->session->sess_destroy();
		redirect();
	}
		
}

// End of file signin.php
// Location: ./controllers/signin.php