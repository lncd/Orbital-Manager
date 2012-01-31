<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function ping()
	{
	
		$ping_response = $this->orbital->core_ping();
	
		$data = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $this->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->config->item('orbital_core_location'),
			'page_title' => 'Core Ping',
			'ping_response_message' => $ping_response->message,
			'ping_response_orbital_institution' => $ping_response->orbital->institution_name,
			'ping_response_orbital_version' => $ping_response->orbital->core_version,
			'ping_response_orbital_timestamp' => $ping_response->orbital->request_timestamp,
		);
	
		$this->parser->parse('includes/header', $data);
		$this->parser->parse('core_ping', $data);
		$this->parser->parse('includes/footer', $data);
	}
}

// EOF