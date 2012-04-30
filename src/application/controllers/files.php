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
			$this->data['project_id'] = $response->response->project->identifier;
			$this->data['page_title'] = $response->response->project->name;
			$this->data['project_name'] = $response->response->project->name;

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('files/view', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}

	/**
	 * Download archive file
	 *
	 * Downloads an archive file from a project
	 */

	function download_file()
	{
		if ($response = $this->orbital->get_otk($identifier))
		{
		}
	}
}

// End of Files.php