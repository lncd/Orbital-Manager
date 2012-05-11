<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Licences extends CI_Controller {

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
	 * Licence view
	 *
	 * Gets details of a specific licence
	 */

	function view_licence($identifier)
	{
		if ($response = $this->orbital->licence_get($identifier))
		{
			$this->data['page_title'] = $response->response->licence->short_name;
			$this->data['licence_name'] = $response->response->licence->short_name;
			$this->data['licence_original_name'] = $response->response->licence->name;
			$this->data['licence_summary_uri'] = $response->response->licence->uri;
			$this->data['licence_enabled'] = $response->response->licence->enabled;
			$this->data['licence_summary'] = $response->response->licence->summary;
			$this->data['licence_allow'] = $response->response->licence->allow_list;
			$this->data['licence_forbid'] = $response->response->licence->forbid_list;
			$this->data['licence_condition'] = $response->response->licence->condition_list;

			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('licences/view_licence', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			show_404();
		}
	}
	
	function view_licence_json($identifier)
	{
		if ($response = $this->orbital->licence_get($identifier))
		{
			$data['name'] = $response->response->licence->short_name;
			$data['original_name'] = $response->response->licence->name;
			$data['summary_uri'] = $response->response->licence->uri;
			$data['summary'] = htmlspecialchars(auto_typography($response->response->licence->summary));
			$data['allow'] = $response->response->licence->allow_list !== NULL ? auto_typography($response->response->licence->allow_list) : NULL;
			$data['forbid'] = $response->response->licence->forbid_list !== NULL ? auto_typography($response->response->licence->forbid_list) : NULL;
			$data['conditions'] = $response->response->licence->condition_list !== NULL ? auto_typography($response->response->licence->condition_list) : NULL;

			$this->output->set_output(json_encode($data));
		}
		else
		{
			show_404();
		}
	}
}

// End of file me.php