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

			if (in_array('write', $response->response->permissions))
			{
				$this->data['project_controls'][] = array(
					'uri' => site_url('project/' . $response->response->project->_id . '/edit'),
					'title' => 'Edit'
				);
			}

			if (!isset($response->response->project->start_date) && !isset($response->response->project->end_date))
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

	function edit($identifier)
	{
		if ($response = $this->orbital->project_details($identifier))
		{
			$this->load->library('typography');
			$this->data['project_id'] = $response->response->project->_id;
			$this->data['page_title'] = 'Edit ' . $response->response->project->name;
			$this->data['project_name'] = $response->response->project->name;

			if (in_array('write', $response->response->permissions))
			{
				$this->data['project_controls'][] = array(
					'uri' => site_url('project/' . $response->response->project->_id . '/edit'),
					'title' => 'Edit'
				);
			}

			foreach($response->response->users as $user => $permissions)
			{
				//Set array of permissions for user
				$user_permissions = array();
				
				//Gert permissions and set as true or false
				$user_permissions['permission_read'] = FALSE;
				if (in_array('read', $permissions))
				{
					$user_permissions['permission_read'] = TRUE;
				}
				$user_permissions['permission_write'] = FALSE;
				if (in_array('write', $permissions))
				{
					$user_permissions['permission_write'] = TRUE;
				}
				$user_permissions['permission_delete'] = FALSE;
				if (in_array('delete', $permissions))
				{
					$user_permissions['permission_delete'] = TRUE;
				}
				$user_permissions['permission_archivefiles_write'] = FALSE;
				if (in_array('archivefiles_write', $permissions))
				{
					$user_permissions['permission_archivefiles_write'] = TRUE;
				}
				$user_permissions['permission_archivefiles_read'] = FALSE;
				if (in_array('archivefiles_read', $permissions))
				{
					$user_permissions['permission_archivefiles_read'] = TRUE;
				}
				$user_permissions['permission_sharedworkspace_read'] = FALSE;
				if (in_array('sharedworkspace_read', $permissions))
				{
					$user_permissions['permission_sharedworkspace_read'] = TRUE;
				}
				$user_permissions['permission_dataset_create'] = FALSE;
				if (in_array('dataset_create', $permissions))
				{
					$user_permissions['permission_dataset_create'] = TRUE;
				}

				$this->data['project_users'][] = array('user' => $user, 'permissions' => $user_permissions);
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

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('projects/edit', $this->data);
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