<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archive extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();

		$this->data = $this->orbital->common_content();
	}

	function upload()
	{
		$this->data['page_title'] = 'Archive Upload';
		$this->data['core_url'] = $this->config->item('orbital_core_location');

		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('archive/upload', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
}

// End of file core.php