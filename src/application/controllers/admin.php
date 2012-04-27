<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}
	
	function index()
	{
		if ($this->session->userdata('system_admin'))
		{
			$this->data['page_title'] = 'System Administration';
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('admin/navigation', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
		else
		{
			$this->data['page_title'] = 'Access Denied';
			$this->data['error_title'] = 'Access Denied';
			$this->data['error_text'] = 'You do not have permission to access the Orbital system administration interface.';
			$this->data['error_technical'] = 'not_admin: User is not a system administrator.';
			
			
			$this->output->set_status_header('403');
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('static/error', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
	
	function mongo_status()
	{
	
		if ($status_response = $this->orbital->core_server_status())
		{
		
			$this->load->helper('date');
	
			$this->data['page_title'] = 'Database Status';
			$this->data['server_host'] = $status_response->response->server->host;
			$this->data['server_version'] = $status_response->response->server->version;
			$this->data['server_uptime'] = $status_response->response->server->uptime;
			$this->data['server_uptime_pretty'] = timespan(time() - $status_response->response->server->uptime, time());
			$this->data['server_local_time'] = $status_response->response->server->localTime->sec;
			$this->data['server_local_time_pretty'] = date('c', $status_response->response->server->localTime->sec);
			$this->data['server_lock_ratio'] = round($status_response->response->server->globalLock->ratio * 100, 4);
			$this->data['server_lock_queue_total'] = $status_response->response->server->globalLock->currentQueue->total;
			$this->data['server_lock_queue_read'] = $status_response->response->server->globalLock->currentQueue->readers;
			$this->data['server_lock_queue_write'] = $status_response->response->server->globalLock->currentQueue->writers;
			$this->data['server_active_clients_total'] = $status_response->response->server->globalLock->activeClients->total;
			$this->data['server_active_clients_read'] = $status_response->response->server->globalLock->activeClients->readers;
			$this->data['server_active_clients_write'] = $status_response->response->server->globalLock->activeClients->writers;
			$this->data['server_memory_architecture'] = $status_response->response->server->mem->bits;
			$this->data['server_memory_resident'] = $status_response->response->server->mem->resident;
			$this->data['server_memory_virtual'] = $status_response->response->server->mem->virtual;
			$this->data['server_memory_mapped'] = $status_response->response->server->mem->mapped;
			$this->data['server_connections_current'] = $status_response->response->server->connections->current;
			$this->data['server_connections_available'] = $status_response->response->server->connections->available;
			
			$this->data['status_servers'] = array();
			
			if (isset($status_response->response->replica_set) && $status_response->response->replica_set !== FALSE)
			{
				foreach ($status_response->response->replica_set->members as $member)
				{
					$this->data['status_servers'][] = array(
						'server_id' => $member->_id,
						'server_name' => $member->name,
						'server_state' => ucwords(strtolower($member->stateStr))
					);
				}
			}
			
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('admin/mongo_status', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
	
	function licences()
	{
	
		if ($licences_response = $this->orbital->licences_list())
		{
			
			$this->data['page_title'] = 'Data Licences';
			$this->data['licences'] = array();
			
			foreach ($licences_response->response->licences as $licence)
			{
				$this->data['licences'][] = $licence;
			}
			
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('admin/licences', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
	
	function licences_add()
	{
	
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('shortname', 'Short name', 'trim|required');
		$this->form_validation->set_rules('url', 'URL', 'trim|required');
		
		if ($this->form_validation->run() === TRUE)
		{
			if ($this->orbital->licence_create($this->input->post('name'), $this->input->post('shortname'), $this->input->post('url')))
			{
				$this->session->set_flashdata('message', 'Licence added successfully. Remember to enable it before it can be used.');
				$this->session->set_flashdata('message_type', 'success');
			}
			else
			{
				$this->session->set_flashdata('message', 'Something went wrong adding this licence.');
				$this->session->set_flashdata('message_type', 'error');
			}
		}
		else
		{
			$this->session->set_flashdata('message', 'Unable to add licence: ' . validation_errors());
			$this->session->set_flashdata('message_type', 'error');
			
		}
	
		redirect('admin/licences');
	
	}
}

// End of file admin.php