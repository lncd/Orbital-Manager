<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Me extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}

	/**
	 * User details
	 *
	 * Retrieves current user details.
	 */

	function index()
	{
	
		if ($response = $this->orbital->user_details())
		{
			$this->data['user_name'] = $response->response->user->name;
			$this->data['institution'] = $response->response->user->institution;
			$this->data['page_title'] = 'My Profile';
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('user/me', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
}

// End of file me.php