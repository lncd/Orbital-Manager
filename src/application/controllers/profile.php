<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $_data = array();

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}

	/**
	 * User details
	 *
	 * Retrieves current user details.
	 *
	 * @return NULL
	 */

	function index()
	{
	
		if ($response = $this->orbital->user_details())
		{
			$this->data['user_name'] = $response->response->user->name;
			$this->data['institution'] = $response->response->user->institution;
			
			$this->data['timeline'] = array();
				
			if (count($response->response->timeline) > 0)
			{
				
				foreach ($response->response->timeline as $item)
				{
					$this->data['timeline'][$item->timestamp_unix] = $item;
				}
				
				$now->id = 'now';
				$now->text = 'Now';
				$now->payload = NULL;
				$now->visibility = 'public';
				$now->timestamp_human = date('g.ia');
				
				$this->data['timeline'][time()] = $now;
				
				ksort($this->data['timeline']);
				
			}
			
			$this->data['page_title'] = 'My Profile';
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('user/me', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
}

// End of file profile.php