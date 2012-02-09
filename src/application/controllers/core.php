<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {

	private $data = array();

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
			$this->data['user_presence'] = '<a href="' . base_url() . 'signin">Sign In</a>';
		}
	}

	function ping()
	{
	
		$ping_response = $this->orbital->core_ping();
	
		$this->data['page_title'] = 'Core Ping';
		$this->data['ping_response_message'] = $ping_response->response->message;
		$this->data['ping_response_orbital_institution'] = $ping_response->orbital->institution_name;
		$this->data['ping_response_orbital_version'] = $ping_response->orbital->core_version;
		$this->data['ping_response_orbital_timestamp'] = $ping_response->orbital->request_timestamp;
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('core/ping', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
}

// End of file core.php