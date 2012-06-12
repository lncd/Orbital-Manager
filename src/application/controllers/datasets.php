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
			//		redirect('project/' . $project_identifier . '?special=new');
				}
				else
				{
					$this->session->set_flashdata('message', 'Something went wrong creating the dataset');
					$this->session->set_flashdata('message_type', 'error');
			//		redirect('project/' . $project_identifier);
				}
			}
			else
			{
				$this->session->set_flashdata('message', 'The dataset is missing some data');
				$this->session->set_flashdata('message_type', 'alert');
		//		redirect('project/' . $project_identifier);
			}
		}
		else
		{
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('datasets/add_dataset', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
}

// End of Datasets.php