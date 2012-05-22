<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller {

	private $_data = array();

	/**
	 * Constructor
	 */
	 
	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}
	
	/**
	 * Project Planner
	 */
	 
	function project_planner()
	{	
		$this->data['page_title'] = 'Project Planner';
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('static/project_planner', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
}

// End of file tools.php