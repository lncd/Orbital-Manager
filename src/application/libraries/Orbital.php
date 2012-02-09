<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Orbital {

	public function common_content()
	{
	
		$CI =& get_instance();
	
		$common_content = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $CI->config->item('orbital_manager_name'),
			'orbital_manager_version' => $CI->config->item('orbital_manager_version'),
			'orbital_core_location' => $CI->config->item('orbital_core_location')
		);
		
		if ($CI->session->userdata('current_user_name'))
		{
			$common_content['user_presence'] = 'Signed in as <a href="#">' . $CI->session->userdata('current_user_name') . '</a>';
		}
		else
		{
			$common_content['user_presence'] = '<a href="' . site_url('signin') . '">Sign In</a>';
		}
		
		$common_content['nav_menu'] = array(
			array (
				'title' => 'Main Menu',
				'items' => array (
					array (
						'name' => 'Home',
						'uri' => site_url()
					),
					array (
						'name' => 'About',
						'uri' => site_url('about')
					),
					array (
						'name' => 'Contact',
						'uri' => site_url('contact')
					)
				)
			),
			array (
				'title' => 'Other Menu',
				'items' => array (
					array (
						'name' => 'Item 1',
						'uri' => site_url('one')
					),
					array (
						'name' => 'Item 2',
						'uri' => site_url('three')
					),
					array (
						'name' => 'Item 3',
						'uri' => site_url('two')
					)
				)
			)
		);
		
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