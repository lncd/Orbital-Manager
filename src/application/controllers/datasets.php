<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datasets extends CI_Controller {

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
	 * View dataset
	 *
	 * views a dataset
	 *
	 * @param string $identifier The dataset identifier
	 * @return NULL
	 */

	function view_dataset($identifier)
	{
		if ($response = $this->orbital->dataset_get_details($identifier))
		{
			$this->load->helper('number');
			$this->load->library('typography');
			
			$this->data['dataset_id'] = $response->response->dataset->id;
			$this->data['dataset_project'] = $response->response->dataset->project_name;
			$this->data['dataset_project_id'] = $response->response->dataset->project;
			$this->data['dataset_title'] = $response->response->dataset->title;
			$this->data['dataset_token'] = $response->response->dataset->token;
			$this->data['page_title'] = $response->response->dataset->title;
			//$this->data['archive_files'] = $response->response->archive_files;
			
			$datasset_size = NULL;
		//	foreach ($response->response->archive_files as $archive_file)
		//	{
		//		$file_set_size = $file_set_size + $archive_file->size;
		//	}
			
			
			if ($response->response->permissions->write)
			{
				$this->data['file_controls'][] = array(
					'uri' => site_url('dataset/' . $response->response->dataset->id . '/edit'),
					'title' => 'Edit'
				);
			}
			

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('datasets/view_dataset', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}

	
	/**
	 * Create new dataset
	 *
	 * creates a dataset
	 *
	 * @return NULL
	 */


	function create_new_dataset($project_identifier)
	{
		$this->data['page_title'] = 'Create New Dataset';
		
		$response = $this->orbital->project_details($project_identifier);

		$this->data['file_set_project'] = $response->response->project->identifier;
		$this->data['file_set_project_name'] = $response->response->project->name;
			
		if($this->input->post('dataset_name') AND $this->input->post('dataset_name') !== '')
		{
			if($this->input->post('dataset_description') AND $this->input->post('datasetdescription') !== '')
			{
				if ($response = $this->orbital->create_new_dataset($this->data['file_set_project'], $this->input->post('dataset_name'), $this->input->post('dataset_description')))
				{					
					$this->session->set_flashdata('message', 'Your dataset has been created!');
					$this->session->set_flashdata('message_type', 'success');
					redirect('project/' . $project_identifier . '?special=new');
				}
				else
				{
					$this->session->set_flashdata('message', 'Something went wrong creating the dataset');
					$this->session->set_flashdata('message_type', 'error');
					redirect('project/' . $project_identifier);
				}
			}
			else
			{
				$this->session->set_flashdata('message', 'The dataset is missing some data');
				$this->session->set_flashdata('message_type', 'alert');
				redirect('project/' . $project_identifier);
			}
		}
		else
		{
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('datasets/add_dataset', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
	
	function list_datasets($identifier)
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
				
				$this->data['datasets'] = $response->response->datasets;
				
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('datasets/list_datasets', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
			else
			{
				show_404();
			}
		}
	}
}

// End of Datasets.php