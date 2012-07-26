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
		if ($identifier !== 'create' AND $response = $this->orbital->dataset_get_details($identifier))
		{
			$this->load->helper('number');
			$this->load->library('typography');
			
			$this->data['dataset_id'] = $response->response->dataset->id;
			$this->data['dataset_project'] = $response->response->dataset->project_name;
			$this->data['dataset_project_id'] = $response->response->dataset->project;
			$this->data['dataset_title'] = $response->response->dataset->title;
			$this->data['dataset_token'] = $response->response->dataset->token;
			$this->data['page_title'] = $response->response->dataset->title;
			$this->data['queries'] = $response->response->dataset_queries;
			$this->data['count'] = $response->response->count;
			
			//$this->data['archive_files'] = $response->response->archive_files;
			
			$datasset_size = NULL;
		//	foreach ($response->response->archive_files as $archive_file)
		//	{
		//		$file_set_size = $file_set_size + $archive_file->size;
		//	}
			
			$this->data['permission_write'] = $response->response->permissions->write;	
			$this->data['permission_delete'] = $response->response->permissions->delete;	
			

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
			if($this->input->post('dataset_description') AND $this->input->post('dataset_description') !== '')
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
	
		
	/**
	 * View query
	 *
	 * views a query
	 *
	 * @param string $identifier The query identifier
	 * @return NULL
	 */

	function view_query($query_identifier)
	{
		if ($response = $this->orbital->query_get_details($query_identifier))
		{
			$this->load->helper('number');
			$this->load->library('typography');
			
			$this->data['query_id'] = $response->response->query[0]->id;
			$this->data['query_name'] = $response->response->query[0]->query;
			$this->data['query_dataset'] = $response->response->query[0]->set;
			
			
			if (isset($response->response->query[0]->value->fields))
			{
				$this->data['query_fields'][] = $response->response->query[0]->value->fields;
			}
			if (isset($response->response->query[0]->value->statements))
			{
				$this->data['query_fields'][] = $response->response->query[0]->value->statements;
			}
			$this->data['page_title'] = $response->response->query[0]->query;

			if ($response = $this->orbital->dataset_get_details($this->data['query_dataset']))
			{			
				$this->data['dataset_project'] = $response->response->dataset->project_name;
				$this->data['dataset_project_id'] = $response->response->dataset->project;
				$this->data['dataset_title'] = $response->response->dataset->title;

				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('datasets/view_query', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}
	
	
	/**
	 * Create query
	 *
	 * creates a query
	 *
	 * @return NULL
	 */


	function create_query($dataset_id)
	{
		$output_variable = NULL;
		
		$this->data['page_title'] = 'Query Builder ';
		
		if ($response = $this->orbital->dataset_get_details($dataset_id))
		{
		
			$this->load->helper('number');
			$this->load->library('typography');
			
			$this->data['dataset_id'] = $response->response->dataset->id;
			$this->data['dataset_project'] = $response->response->dataset->project_name;
			$this->data['dataset_project_id'] = $response->response->dataset->project;
			$this->data['dataset_title'] = $response->response->dataset->title;
			$this->data['dataset_token'] = $response->response->dataset->token;
			$this->data['page_title'] = $response->response->dataset->title;
		
			if($this->input->post('query_name') AND $this->input->post('query_name') !== '')
			{
				if ($response = $this->orbital->create_query($dataset_id, $this->input->post('query_name')))
				{
					$this->session->set_flashdata('message', 'Your query has been built!');
					$this->session->set_flashdata('message_type', 'success');
					redirect('dataset/' . $dataset_id);			
				}
				else
				{
					$this->session->set_flashdata('message', 'Something went wrong creating the query');
					$this->session->set_flashdata('message_type', 'error');
					redirect('dataset/' . $dataset_id . '/query');
				}
			}
			else
			{
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('datasets/add_query', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
		}
		else
		{
			show_404();
		}
	}

	
	/**
	 * Build query
	 *
	 * builds a query
	 *
	 * @return NULL
	 */


	function edit_query($query_identifier)
	{
		$output_variable = NULL;
		
		$this->data['page_title'] = 'Query Builder ';
		
		$this->load->helper('number');
		$this->load->library('typography');
		
		if ($response = $this->orbital->query_get_details($query_identifier))
		{			
			$this->data['page_title'] = $response->response->query[0]->query;
			$this->data['query_id'] = $response->response->query[0]->id;
			$this->data['query_name'] = $response->response->query[0]->query;
			$this->data['query_dataset'] = $response->response->query[0]->set;
			$this->data['statements'] = NULL;
			$this->data['fields'] = NULL;
			
			
			if ($response = $this->orbital->dataset_get_details($this->data['query_dataset']))
			{			
				$this->data['dataset_project'] = $response->response->dataset->project_name;
				$this->data['dataset_project_id'] = $response->response->dataset->project;
				$this->data['dataset_title'] = $response->response->dataset->title;
			}
			else
			{
				//NO DATASET FOUND FOR QUERY
			}
			
			if (isset($response->response->query[0]->value->statements))
			{
				$this->data['statements'] = (array)$response->response->query[0]->value->statements;
			}
			if (isset($response->response->query[0]->value->fields))
			{
				$this->data['fields'] = (array)$response->response->query[0]->value->fields;
			}
		
			if($this->input->post('query_name') AND $this->input->post('query_name') !== '')
			{
				if($this->input->post('statements'))
				{	
					$statements_array = array();
					$fields_array = array();
				
					$includes = $this->input->post('include');
				
					foreach ($this->input->post('statements') as $field => $statement)
					{
						foreach ($statement as $operator => $value)
						{
							if (isset($includes[$field][$operator]))
							{
								$statements_array[$field][$operator] = $value;						
							}
						}
					}	
					if($this->input->post('output_fields'))
					{	
						foreach ($this->input->post('output_fields') as $field)
						{
							$fields_array[] = $field;
						}
					}
					
					if ($response = $this->orbital->update_query($query_identifier, $this->input->post('query_name'), $statements_array, $fields_array))
					{
						$this->session->set_flashdata('message', 'Your query has been edited!');
						$this->session->set_flashdata('message_type', 'success');
						redirect('query/' . $query_identifier);			
					}
					else
					{
						$this->session->set_flashdata('message', 'Something went wrong editing the query');
						$this->session->set_flashdata('message_type', 'error');
						redirect('query/' . $query_identifier . '/edit');
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'The query is missing some data');
					$this->session->set_flashdata('message_type', 'alert');
					redirect('query/' . $query_identifier . '/edit');
				}
			}
			else
			{
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('datasets/edit_query', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			}
		}
		else
		{
			show_404();
		}
		
	}

	
	/**
	 * Delete query
	 *
	 * deletes a query
	 *
	 * @return NULL
	 */


	function delete_query($query_identifier)
	{
		
		$this->load->helper('number');
		$this->load->library('typography');
		
		if ($response = $this->orbital->query_get_details($query_identifier))
		{								
			if ($response = $this->orbital->delete_query($query_identifier))
			{
				$this->session->set_flashdata('message', 'Your query has been deleted!');
				$this->session->set_flashdata('message_type', 'success');
				redirect('query/' . $query_identifier);			
			}
			else
			{
				$this->session->set_flashdata('message', 'Something went wrong deleting the query');
				$this->session->set_flashdata('message_type', 'error');
				redirect('query/' . $query_identifier);
			}
		}
		else
		{
			show_404();
		}
		
	}
}

// End of Datasets.php