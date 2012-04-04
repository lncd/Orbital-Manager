<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archive extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();

		$this->data = $this->orbital->common_content();
	}

	function upload($project_id)
	{
	
		if ($response = $this->orbital->project_details($project_id))
		{
			$this->load->library('typography');
			$this->data['project_id'] = $response->response->project->identifier;
		
			$this->data['page_title'] = 'Archive Upload';
			$this->data['core_url'] = $this->config->item('orbital_core_location');
	
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('archive/upload', $this->data);
			$this->parser->parse('includes/footer', $this->data);
			
		}
		else
		{
			show_404();
		}
	}
}

// End of file core.php