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
		
		if ($CI->session->userdata('current_user_string'))
		{
			$common_content['user_presence'] = 'Signed in as <a href="' . site_url('me') . '">' . $CI->session->userdata('current_user_string') . '</a> &middot; <a href="' . site_url('signout') . '">Sign Out</a>';
		}
		else
		{
			$common_content['user_presence'] = '<a href="' . site_url('signin') . '">Sign In</a>';
		}
		
		$common_content['nav_menu'] = array (
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
		);
			
		if ($CI->session->userdata('current_user_string'))
		{
			
			$common_content['nav_menu'][] = array (
				'name' => 'Projects',
				'uri' => site_url('projects')
			);
			
			$common_content['nav_menu'][] = array (
				'name' => 'Me',
				'uri' => site_url('me')
			);
			
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