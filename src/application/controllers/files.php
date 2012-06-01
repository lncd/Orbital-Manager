<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends CI_Controller {

	private $_data = array();

	/**
	 * Contruct
	 */

	function __construct()
	{
		parent::__construct();

		$this->data = $this->orbital->common_content();
	}

	function list_files($identifier)
	{
		if ($response = $this->orbital->project_details($identifier))
		{
			if ($response->response->status === TRUE)
			{
				$this->load->helper('number');
				if ($this->input->get('error'))
				{
					$this->data['error'] = $this->input->get('error');
				}

				if ($this->input->get('message'))
				{
					$this->data['success'] = $this->input->get('message');
				}

				$this->load->library('typography');
				$this->data['project_id'] = $response->response->project->identifier;
				$this->data['page_title'] = $response->response->project->name;
				$this->data['project_name'] = $response->response->project->name;

				// Generate list of archive files

				$this->data['archive_files'] = $response->response->archive_files;
				
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('files/list', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
			else
			{
				show_404();
			}
		}
	}
	
	function list_file_sets($identifier)
	{
		if ($response = $this->orbital->project_details($identifier))
		{
			if ($response->response->status === TRUE)
			{
				if ($this->input->get('error'))
				{
					$this->data['error'] = $this->input->get('error');
				}

				if ($this->input->get('message'))
				{
					$this->data['success'] = $this->input->get('message');
				}

				$this->load->library('typography');
				$this->data['project_id'] = $response->response->project->identifier;
				$this->data['page_title'] = $response->response->project->name;
				$this->data['project_name'] = $response->response->project->name;
				
				//Generate list of file_sets
				
				$this->data['file_sets'] = $response->response->file_sets;
				
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('files/list_file_sets', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
			else
			{
				show_404();
			}
		}
	}

	/**
	 * View file details
	 *
	 * views a files details
	 *
	 * @param string $identifier
	 * @return NULL
	 */

	function view_file($identifier)
	{
		if ($response = $this->orbital->file_get_details($identifier))
		{
			$this->load->library('typography');
			
			$this->data['file_id'] = $response->response->file->id;
			$this->data['file_project'] = $response->response->file->project_name;
			$this->data['file_project_id'] = $response->response->file->project;
			$this->data['file_title'] = $response->response->file->title;
			$this->data['file_name'] = $response->response->file->original_name;
			$this->data['file_licence'] = $response->response->file->licence_name;
			$this->data['file_licence_uri'] = $response->response->file->licence_uri;
			$this->data['file_extension'] = $response->response->file->extension;
			$this->data['file_mimetype'] = $response->response->file->mimetype;
			$this->data['page_title'] = $response->response->file->original_name;
			
			if ($response->response->permissions->write)
			{
				$this->data['file_controls'][] = array(
					'uri' => site_url('file/' . $response->response->file->id . '/edit'),
					'title' => 'Edit'
				);
			}
			
			if ($response->response->file->status === 'uploaded')
			{
				$this->data['file_downloadable'] = TRUE;
			}
			else
			{
				$this->data['file_downloadable'] = FALSE;
			}

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/view_file', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}

	/**
	 * View file set details
	 *
	 * views a file sets details
	 *
	 * @param string $identifier
	 * @return NULL
	 */

	function view_file_set($identifier)
	{
		if ($response = $this->orbital->file_set_get_details($identifier))
		{
			$this->load->helper('number');
			$this->load->library('typography');
			
			$this->data['file_set_id'] = $response->response->file_set->id;
			$this->data['file_set_project'] = $response->response->file_set->project_name;
			$this->data['file_set_project_id'] = $response->response->file_set->project;
			$this->data['file_set_title'] = $response->response->file_set->title;
			$this->data['page_title'] = $response->response->file_set->title;
			$this->data['archive_files'] = $response->response->archive_files;
			
			if ($response->response->permissions->write)
			{
				$this->data['file_controls'][] = array(
					'uri' => site_url('collection/' . $response->response->file_set->id . '/edit'),
					'title' => 'Edit'
				);
			}
			

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/view_file_set', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}
	
	
	/**
	 * Edit file set details
	 *
	 * edits a file sets details
	 *
	 * @param string $identifier
	 * @return NULL
	 */

	function edit_file_set($identifier)
	{
		if ($response = $this->orbital->file_set_get_details($identifier))
		{
			$this->load->helper('number');
			$this->load->library('typography');
			
			if($this->input->post('file_set_name'))
			{
			
				$this->orbital->file_set_update($identifier, $this->input->post('file_set_name'), $this->input->post('file_set_description'));
				
				$this->session->set_flashdata('message', 'File collection details updated successfully.');
				$this->session->set_flashdata('message_type', 'success');
				redirect('collection/' . $identifier);
			}
			
			$this->data['file_set_id'] = $response->response->file_set->id;
			$this->data['file_set_project'] = $response->response->file_set->project_name;
			$this->data['file_set_description'] = $response->response->file_set->description;
			$this->data['file_set_title'] = $response->response->file_set->title;
			$this->data['page_title'] = $response->response->file_set->title;
			$this->data['archive_files'] = $response->response->archive_files;
			
			if ($response->response->permissions->write)
			{
				$this->data['file_controls'][] = array(
					'uri' => site_url('collection/' . $response->response->file_set->id . '/edit'),
					'title' => 'Edit'
				);
			}
			

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/edit_file_set', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}


	/**
	 * Create new file set
	 *
	 * creates a file set
	 *
	 * @return NULL
	 */


	function create_new_file_set($identifier)
	{
		if($this->input->post('file_set_name') AND $this->input->post('file_set_name') !== '')
		{
			if($this->input->post('file_set_description') AND $this->input->post('file_set_description') !== '')
			{
				if ($response = $this->orbital->create_new_file_set($identifier, $this->input->post('file_set_name'), $this->input->post('file_set_description')))
				{	
					$this->session->set_flashdata('message', 'Your file set has been created!');
					$this->session->set_flashdata('message_type', 'success');
					redirect('project/' . $response->response->project_id . '?special=new');
				}
				else
				{
					$this->session->set_flashdata('message', 'Something went wrong creating the project');
					$this->session->set_flashdata('message_type', 'error');
					redirect('projects');
				}
			}
			else
			{
				$this->session->set_flashdata('message', 'A project must have an abstract');
				$this->session->set_flashdata('message_type', 'alert');
				redirect('projects');
			}
		}
		else
		{
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/add_file_set', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}

	/**
	 * View public file set details
	 *
	 * views a public file sets details
	 *
	 * @param string $identifier
	 * @return NULL
	 */

	function view_file_set_public($identifier)
	{
		if ($response = $this->orbital->file_set_get_details($identifier))
		{
			$this->load->helper('number');
			$this->load->library('typography');
			
			$this->data['file_set_id'] = $response->response->file_set->id;
			$this->data['file_set_project'] = $response->response->file_set->project_name;
			$this->data['file_set_project_id'] = $response->response->file_set->project_id;
			$this->data['file_set_title'] = $response->response->file_set->title;
			$this->data['file_set_name'] = $response->response->file_set->original_name;
			$this->data['file_set_licence'] = $response->response->file_set->licence_name;
			$this->data['file_set_licence_uri'] = $response->response->file_set->licence_uri;
			$this->data['file_set_extension'] = $response->response->file_set->extension;
			$this->data['file_set_mimetype'] = $response->response->file_set->mimetype;
			$this->data['page_title'] = $response->response->file_set->original_name;
			
			if ($response->response->permissions->write)
			{
				$this->data['file_controls'][] = array(
					'uri' => site_url('file/' . $response->response->file->id . '/edit'),
					'title' => 'Edit'
				);
			}
			
			if ($response->response->file->status === 'uploaded')
			{
				$this->data['file_downloadable'] = TRUE;
			}
			else
			{
				$this->data['file_downloadable'] = FALSE;
			}

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/view_file_set_public', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}


	/**
	 * View file details public
	 *
	 * views a public files details
	 *
	 * @param string $identifier
	 * @return NULL
	 */

	function view_file_public($identifier)
	{
		if ($response = $this->orbital->file_get_details_public($identifier))
		{
			$project = $this->orbital->project_public_details($response->response->file->project);
			$this->load->library('typography');
			
			$this->data['file_id'] = $response->response->file->id;
			$this->data['file_project'] = $response->response->file->project_name;
			$this->data['file_project_id'] = $response->response->file->project;
			$this->data['file_title'] = $response->response->file->title;
			$this->data['file_name'] = $response->response->file->original_name;
			$this->data['file_licence'] = $response->response->file->licence_name;
			$this->data['file_licence_uri'] = $response->response->file->licence_uri;
			$this->data['file_extension'] = $response->response->file->extension;
			$this->data['file_mimetype'] = $response->response->file->mimetype;
			$this->data['page_title'] = $response->response->file->original_name;
			
			if ($project->response->project->google_analytics !== 'NULL'){
				$this->data['alt_tracking'] = $project->response->project->google_analytics;
			}
			
			if ($response->response->file->status === 'uploaded')
			{
				$this->data['file_downloadable'] = TRUE;
			}
			else
			{
				$this->data['file_downloadable'] = FALSE;
			}

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/view_file_public', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}
	
	

	/**
	 * Edit file details
	 *
	 * edits a files details
	 *
	 * @param string $identifier
	 * @return NULL
	 */

	function edit_file($identifier)
	{
		if ($response = $this->orbital->file_get_details($identifier))
		{
			$licences = $this->orbital->licences_enabled_list();
			$this->data['licences'] = $licences->response->licences;
			
			if($this->input->post('default_licence'))
			{
				
				if ($this->input->post('public') === 'public')
				{
					$public_view = 'public';
				}
				else
				{
					$public_view = 'private';
				}
			
				$this->orbital->file_update($identifier, $this->input->post('name'), (int)$this->input->post('default_licence'), $public_view);
				
				$this->session->set_flashdata('message', 'File details updated successfully.');
				$this->session->set_flashdata('message_type', 'success');
				redirect('file/' . $identifier);
			}
		
			$this->load->library('typography');
			
			$this->data['file_id'] = $response->response->file->id;
			$this->data['file_project'] = $response->response->file->project_name;
			$this->data['file_project_id'] = $response->response->file->project;
			$this->data['file_title'] = $response->response->file->title;
			$this->data['file_name'] = $response->response->file->original_name;
			$this->data['file_licence'] = $response->response->file->licence;
			$this->data['file_licence_uri'] = $response->response->file->licence_uri;
			$this->data['file_extension'] = $response->response->file->extension;
			$this->data['file_mimetype'] = $response->response->file->mimetype;
			if (isset($response->response->file->visibility))
			{			
				if ($response->response->file->visibility === 'public')
				{
					$this->data['file_public_view'] = TRUE;
				}
				else
				{
					$this->data['file_public_view'] = FALSE;
				}
			}
			else
			{
				$this->data['file_public_view'] = TRUE;
			}
			$this->data['page_title'] = 'Edit ' . $response->response->file->original_name;
			
			if ($response->response->file->status === 'uploaded')
			{
				$this->data['file_downloadable'] = TRUE;
			}
			else
			{
				$this->data['file_downloadable'] = FALSE;
			}

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/edit_file', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}

	/**
	 * Download archive file
	 *
	 * Downloads an archive file from a project
	 *
	 * @param string $identifier
	 * @return NULL
	 */

	function download_file($identifier)
	{
		if ($response = $this->orbital->get_otk($identifier))
		{
			$this->output->set_header('Location: ' . $this->config->item('orbital_core_location') . 'file/' . $identifier . '/download?otk=' . $response->response->otk);
		}
	}
}

// End of Files.php