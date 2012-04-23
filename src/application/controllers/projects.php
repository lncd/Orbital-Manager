<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {

	private $data = array();

	/**
	 * Contruct
	 */

	function __construct()
	{
		parent::__construct();

		$this->data = $this->orbital->common_content();
	}

	/**
	 * Projects list
	 *
	 * Get array of projects and their details
	 */

	function index()
	{

		$this->data['page_title'] = 'My Projects';

		if ($response = $this->orbital->projects_list())
		{

			if (count($response->response->projects) > 0)
			{

				foreach($response->response->projects as $project)
				{
					$output = array('project_name' => $project->name,
						'project_uri' => site_url('project/' . $project->identifier),
					);

					if (isset($project->start_date))
					{
						$output['project_startdate'] = date('D jS F Y', $project->start_date);
					}

					if (isset($project->end_date))
					{
						$output['project_enddate'] = date('D jS F Y', $project->end_date);
					}
					$this->data['projects'][] = $output;
				}
				
				if ($response = $this->orbital->projects_public_list(5))
				{

					if (count($response->response->projects) > 0)
					{

						foreach($response->response->projects as $project)
						{
							$output = array('project_name' => $project->name,
								'project_uri' => site_url('project/' . $project->identifier),
							);

							if (isset($project->start_date))
							{
								$output['project_startdate'] = date('D jS F Y', $project->start_date);
							}

							if (isset($project->end_date))
							{
								$output['project_enddate'] = date('D jS F Y', $project->end_date);
							}
							$this->data['public_projects'][] = $output;


						}
					}
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

	/**
	 * Public Projects list
	 *
	 * Get array of public projects and their details
	 */

	function list_public()
	{
		$this->data['page_title'] = 'Public projects';

		if ($response = $this->orbital->projects_public_list())
		{

			if (count($response->response->projects) > 0)
			{

				foreach($response->response->projects as $project)
				{
					$output = array('project_name' => $project->name,
						'project_uri' => site_url('project/' . $project->identifier)
					);

					if (isset($project->start_date))
					{
						$output['project_startdate'] = date('D jS F Y', $project->start_date);
					}

					if (isset($project->end_date))
					{
						$output['project_enddate'] = date('D jS F Y', $project->end_date);
					}
					$output['research_group'] = '';
					if(isset($project->research_group))
					{
						$output['research_group'] = $project->research_group;
					}
					
					$this->data['projects'][] = $output;


				}

				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('projects/public', $this->data);
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

	/**
	 * Project view
	 *
	 * Gets details of a specific project
	 */

	function view($identifier)
	{
		if ($response = $this->orbital->project_details($identifier))
		{
			$this->load->library('typography');
			$this->data['project_id'] = $response->response->project->identifier;
			$this->data['page_title'] = $response->response->project->name;
			$this->data['project_name'] = $response->response->project->name;

			//Check for Edit permissions
			if (in_array('write', $response->response->permissions))
			{
				$this->data['project_controls'][] = array(
					'uri' => site_url('project/' . $response->response->project->identifier . '/edit'),
					'title' => 'Edit'
				);
			}

			//Check for Delete permissions
			if (in_array('delete', $response->response->permissions))
			{
				$this->data['project_controls'][] = array(
					'uri' => site_url('project/' . $response->response->project->identifier . '/delete'),
					'title' => 'Delete'
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

			if (isset($response->response->project->start_date) and isset($response->response->project->end_date) and $response->response->project->end_date > $response->response->project->start_date)
			{
				$this->data['project_complete'] = abs(((time() - $response->response->project->start_date) / ($response->response->project->end_date - $response->response->project->start_date)) * 100);
			}
			
			// Generate workspace modes
			
			$this->data['workspace_project'] = false;
			$this->data['workspace_personal'] = false;
			
			// Generate list of datasets
			
			$this->data['working_datasets'] = array('foo');
			
			// Generate list of archive files
			
			$this->data['archive_files'] = array();

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('projects/view', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}

	/**
	 * Edit project
	 *
	 * Gets project details, users and their permissions
	 */

	function edit($identifier)
	{
		if ($response = $this->orbital->project_details($identifier))
		{
			if($this->input->post('name') and $this->input->post('abstract'))
			{
				$this->orbital->update_project($identifier, $this->input->post('name'), $this->input->post('abstract'));
				$response = $this->orbital->project_details($identifier);
			}
			
			if($this->input->post('save_members_details'))
			{/*
				$this->orbital->update_project_members($identifier,
				$this->input->post('read'),
				$this->input->post('write'),
				$this->input->post('delete'),
				$this->input->post('archivefiles_read'),
				$this->input->post('archivefiles_write'),
				$this->input->post('sharedworkspace_read'),
				$this->input->post('dataset_create'));
				$response = $this->orbital->project_details($identifier);*/
				print_r($this->input->post());
			}

			$this->load->library('typography');
			$this->data['project_id'] = $response->response->project->identifier;
			$this->data['page_title'] = 'Edit ' . $response->response->project->name;
			$this->data['project_name'] = $response->response->project->name;
			$this->data['project_abstract'] = $response->response->project->abstract;

			if (in_array('write', $response->response->permissions))
			{
				$this->data['project_controls'][] = array(
					'uri' => site_url('project/' . $response->response->project->identifier . '/edit'),
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

				$this->data['project_users'][] = array('user' => $user, 'permissions' => $user_permissions, 'user_email' => base64_encode($user));
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
	
	/**
	 * Create project
	 *
	 * Creates a new project
	 */

	function create()
	{
		if($this->input->post('name') and $this->input->post('name') !== '')
		{
			if ($response = $this->orbital->create_project($this->input->post('name'), $this->input->post('abstract')))
			{
				redirect('project/' . $response->response->project_id);
			}
		}
		else
		{
			$this->session->set_flashdata('message', 'A project must have a name');
			$this->session->set_flashdata('message_type', 'alert');
			redirect('projects');
		}
	}

	/**
	 * Delete project
	 *
	 * Deletes a project
	 */

	function delete($identifier)
	{
		if ($response = $this->orbital->project_details($identifier))
		{
			if($this->input->post('delete'))
			{
				$this->orbital->delete_project($identifier);
				$this->session->set_flashdata('message', 'Project deleted successfully.');
				$this->session->set_flashdata('message_type', 'success');
				redirect('projects/');
			}

			$this->load->library('typography');
			$this->data['project_id'] = $response->response->project->identifier;
			$this->data['page_title'] = 'Delete ' . $response->response->project->name;
			$this->data['project_name'] = $response->response->project->name;
			$this->data['project_abstract'] = $response->response->project->abstract;

			if (in_array('write', $response->response->permissions))
			{
				$this->data['project_controls'][] = array(
					'uri' => site_url('project/' . $response->response->project->identifier . '/delete'),
					'title' => 'Delete'
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
			$this->parser->parse('projects/delete', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			$this->session->set_flashdata('message', $response->response->project->name . ' could not be deleted');
			$this->session->set_flashdata('message_type', 'alert-error');
			redirect('project/' . $identifier);
		}
	}
}

// End of file me.php