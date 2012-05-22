<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function project_planner()
	{	
		$this->data['page_title'] = 'Project Planner';
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('static/project_planner', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
}

// End of file admin.php