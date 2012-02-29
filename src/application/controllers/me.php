<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Me extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}

	function index()
	{
	
		echo 'me';
	
		if ($response = $this->orbital->user_details())
		{
			print_r($response);
		}
	
		/*
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('core/ping', $this->data);
		$this->parser->parse('includes/footer', $this->data);
		*/
	}
}

// End of file me.php