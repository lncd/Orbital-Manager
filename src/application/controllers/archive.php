<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Archive Controller
 *
 * Controls the uploading of files to projects.
 *
 * @category   Controller
 * @package    Orbital
 * @subpackage Manager
 * @author     Harry Newton <hnewton@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
*/

class Archive extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();

		$this->data = $this->orbital->common_content();
	}

	/**
	 * Upload file
	 *
	 * Uploads file to the archive.
	 */

	function upload($project_id)
	{
	
		if ($response = $this->orbital->project_details($project_id))
		{
			$this->load->library('typography');
			$this->data['project_id'] = $response->response->project->identifier;
		
			$this->data['page_title'] = 'Archive Upload';
			$this->data['core_url'] = $this->config->item('orbital_core_location');
	
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('archive/upload', $this->data);
			$this->parser->parse('includes/footer', $this->data);
			
		}
		else
		{
			show_404();
		}
	}
}

// End of file core.php