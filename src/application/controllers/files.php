<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends CI_Controller {

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
	 * View file details
	 *
	 * views a files details
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
			$this->data['file_licence'] = $response->response->file->licence;
			$this->data['file_extension'] = $response->response->file->extension;
			$this->data['file_mimetype'] = $response->response->file->mimetype;
			$this->data['page_title'] = $response->response->file->original_name;

			if ($response->response->project->google_analytics !== 'NULL'){
				$this->data['alt_tracking'] = $response->response->project->google_analytics;
			}

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/view_file', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}

	/**
	 * Download archive file
	 *
	 * Downloads an archive file from a project
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