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
	
		$auth_types = $this->orbital->core_auth_types();
		
		foreach ($auth_types->response as $auth_type)
		{
			$this->data->['auth_types'] = array(
				'name' => $auth_type->name,
				'uri' => $auth_type->uri
			);
		}
		
		$this->data['page_title'] = 'Sign In';
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('user/signin', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
		
}

// End of file static.php
// Location: ./controllers/static.php