<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}

	function ping()
	{
	
		$ping_response = $this->orbital->core_ping();
	
		$this->data['page_title'] = 'Core Ping';
		$this->data['ping_response_message'] = $ping_response->response->message;
		$this->data['ping_response_time'] = $ping_response->response_time;
		$this->data['ping_response_time_pretty'] = date('c', $ping_response->response_time);
		$this->data['ping_response_orbital_institution'] = $ping_response->orbital->institution_name;
		$this->data['ping_response_orbital_version'] = $ping_response->orbital->core_version;
		$this->data['ping_response_orbital_timestamp'] = $ping_response->orbital->request_timestamp;
		$this->data['ping_response_orbital_timestamp_pretty'] = date('c', $ping_response->orbital->request_timestamp);
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('core/ping', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
}

// End of file core.php