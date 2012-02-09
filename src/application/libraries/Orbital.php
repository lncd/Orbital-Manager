<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Orbital {

	public function common_content()
	{
	
		$CI =& get_instance();
	
		$common_content = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $this->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->config->item('orbital_core_location')
		);
		
		if ($this->session->userdata('current_user_name'))
		{
			$common_content['user_presence'] = 'Signed in as <a href="#">' . $this->session->userdata('current_user_name') . '</a>';
		}
		else
		{
			$common_content['user_presence'] = '<a href="' . base_url() . 'signin">Sign In</a>';
		}
		
		return $common_content;
	
	}

	private function get($target)
	{
	
		$CI =& get_instance();
	
		try
		{
			return json_decode(file_get_contents($CI->config->item('orbital_core_location') . $target));
		}
		catch (Exception $e)
		{
			return FALSE;
		}
	
	}

    public function core_ping()
    {
    
    	return $this->get('core/ping');
    
    }
    
    public function core_auth_types()
    {
    
    	return $this->get('core/auth_types');
    
    }
}

/* End of file Orbital.php */