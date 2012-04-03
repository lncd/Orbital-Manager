<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();

		$this->data = $this->orbital->common_content();
	}

	function index()
	{
		if ($response = $this->orbital->projects_list())
		{
			foreach($response->response->projects as $project)
			{
				$this->data['projects'][] = array('project_name' => $project->name, 'project_uri' => site_url('project/' . $project->identifier));
			}
			
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('projects/list', $this->data);
			$this->parser->parse('includes/footer', $this->data);

		}
	}
}

// End of file me.php