<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Orbital {

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
}

/* End of file Someclass.php */