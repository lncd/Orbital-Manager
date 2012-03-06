<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core extends CI_Controller {

	private $data = array();

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}

	function ping()
	{
	
		$ping_response = $this->orbital->core_ping();
	
		$this->data['page_title'] = 'Core Ping';
		$this->data['ping_response_message'] = $ping_response->response->message;
		$this->data['ping_response_time'] = $ping_response->response_time;
		$this->data['ping_response_orbital_institution'] = $ping_response->orbital->institution_name;
		$this->data['ping_response_orbital_version'] = $ping_response->orbital->core_version;
		$this->data['ping_response_orbital_timestamp'] = $ping_response->orbital->request_timestamp;
		$this->data['ping_response_orbital_timestamp_pretty'] = date('c', $ping_response->orbital->request_timestamp);
	
		$this->parser->parse('includes/header', $this->data);
		$this->parser->parse('core/ping', $this->data);
		$this->parser->parse('includes/footer', $this->data);
	}
	
	function database_status()
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
			
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('core/database_status', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
}

// End of file core.php