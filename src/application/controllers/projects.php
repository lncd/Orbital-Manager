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

		$this->data['page_title'] = 'My Projects';

		if ($response = $this->orbital->projects_list())
		{
		
			if (count($response->response->projects) > 0)
			{
		
				foreach($response->response->projects as $project)
				{
					$this->data['projects'][] = array('project_name' => $project->name, 'project_uri' => site_url('project/' . $project->_id));
				}
	
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('projects/list', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
			else
			{
	
				// This user has no projects. Show them this fact!
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('projects/first', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
		}
	}

	function view($identifier)
	{
		if ($response = $this->orbital->project_details($identifier))
		{
			$this->load->library('typography');
			$this->data['project_id'] = $response->response->project->_id;
			$this->data['page_title'] = $response->response->project->name;
			$this->data['project_name'] = $response->response->project->name;

			if (isset($response->response->project->start_date) && isset($response->response->project->end_date))
			{
				//Check for both start and end dates - if not present dont show project progress
			}

			if (isset($response->response->project->start_date))
			{
				$this->data['project_startdate'] = $response->response->project->start_date;
				$this->data['project_startdate_pretty'] = date('D jS F Y', $response->response->project->start_date);
			}
			if (isset($response->response->project->end_date))
			{
				$this->data['project_enddate'] = $response->response->project->end_date;
				$this->data['project_enddate_pretty'] = date('D jS F Y', $response->response->project->end_date);
			}
			$this->data['project_description'] = $this->typography->auto_typography($response->response->project->abstract);

			try
			{
				if ($response->response->project->end_date > $response->response->project->start_date)
				{
					$this->data['project_complete'] = abs(((time() - $response->response->project->start_date) / ($response->response->project->end_date - $response->response->project->start_date)) * 100);
				}
			}
			catch (Exception $e)
			{
				print_r('There was a problem calculating project progress');
			}

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('projects/view', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}

	function create()
	{
		if ($response = $this->orbital->create_project($this->input->post('name'), $this->input->post('abstract')))
		{
			redirect('project/' . $response->response->project_id);
		}
	}
}

// End of file me.php