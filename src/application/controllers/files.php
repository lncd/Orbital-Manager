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
			$this->data['file_title'] = $response->response->file->original_name;
			$this->data['file_name'] = $response->response->file->original_name;
			$this->data['file_licence'] = $response->response->file->licence_name;
			$this->data['file_licence_uri'] = $response->response->file->licence_uri;
			$this->data['file_extension'] = $response->response->file->extension;
			$this->data['file_mimetype'] = $response->response->file->mimetype;
			$this->data['page_title'] = $response->response->file->original_name;
			
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
			$this->data['file_title'] = $response->response->file->original_name;
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
				
				if ($this->input->post('public') === TRUE)
				{
					$public_view = 'visible';
				}
				else
				{
					$public_view = 'hidden';
				}
			
				$this->orbital->file_update($identifier, $this->input->post('name'), (int)$this->input->post('default_licence'), $this->input->post('public'));
				
				$this->session->set_flashdata('message', 'File details updated successfully.');
				$this->session->set_flashdata('message_type', 'success');
				redirect('file/' . $identifier);
			}
		
			$this->load->library('typography');
			
			$this->data['file_id'] = $response->response->file->id;
			$this->data['file_project'] = $response->response->file->project_name;
			$this->data['file_project_id'] = $response->response->file->project;
			$this->data['file_title'] = $response->response->file->original_name;
			$this->data['file_name'] = $response->response->file->original_name;
			$this->data['file_licence'] = $response->response->file->licence_name;
			$this->data['file_licence_uri'] = $response->response->file->licence_uri;
			$this->data['file_extension'] = $response->response->file->extension;
			$this->data['file_mimetype'] = $response->response->file->mimetype;
			$this->data['file_public'] = $response->response->file->visibility;
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