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
<<<<<<< HEAD
	
	/**
	 * Project Planner
	 */
	 
=======

>>>>>>> 93bf7292053c5b3df3c092fac18cb2ff90445334
	function project_planner()
	{	
		$this->data['page_title'] = 'Project Planner';
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('static/project_planner', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
<<<<<<< HEAD
=======
	
	function policy_guidance()
	{	
		$this->data['page_title'] = 'Policy and Guidance';
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('static/policy_guidance', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
>>>>>>> 93bf7292053c5b3df3c092fac18cb2ff90445334
}

// End of file tools.php