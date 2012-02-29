<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Orbital Core Library
 *
 * Manages interfacing with Orbital Core.
 *
 * @category   Library
 * @package    Orbital
 * @subpackage Manager
 * @autho      Nick Jackson <nijackson@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
 *
 * @todo Rewrite to use exceptions.
*/

class Orbital {

	private $_ci;
	
	function __construct()
	{
		$this->_ci =& get_instance();
	}

	public function common_content()
	{
	
		$common_content = array(
			'base_url' => base_url(),
			'orbital_manager_name' => $this->_ci->config->item('orbital_manager_name'),
			'orbital_manager_version' => $this->_ci->config->item('orbital_manager_version'),
			'orbital_core_location' => $this->_ci->config->item('orbital_core_location')
		);
		
		if ($this->_ci->session->userdata('current_user_string'))
		{
			$common_content['user_presence'] = 'Signed in as <a href="' . site_url('me') . '">' . $this->_ci->session->userdata('current_user_string') . '</a> &middot; <a href="' . site_url('signout') . '">Sign Out</a>';
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
			
		if ($this->_ci->session->userdata('current_user_string'))
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

	/**
	 * Refresh Token
	 *
	 * Swaps a refresh token for a new access token and refresh token, and
	 * stores in the session
	 *
	 * @access public
	 *
	 * @param string $token Token to swap.
	 *
	 * @return bool TRUE if swap successful, FALSE if not.
	 */

	public function refresh_token($token)
	{
	
		$postfields = 'grant_type=refresh_token&refresh_token=' . $token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->config->item('orbital_core_location') . 'auth/refresh_token');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_USERPWD, $this->config->item('orbital_app_id') . ':' . $this->config->item('orbital_app_secret'));
		if ($reply = curl_exec($ch))
		{
		
		}
		else
		{
			// Failed. Abort.
			return FALSE;
		}
		
		curl_close ($ch);
	}

	/**
	 * Get (Authenticated)
	 *
	 * Performs an authenticated HTTP GET against Orbital Core.
	 *
	 * @access private
	 *
	 * @param array $scopes Scopes to ensure that the user has access to.
	 *
	 * @return string|FALSE User's email address if credentials match, FALSE
	 *                      if not.
	 */

	private function get_authed($target)
	{
	
		if ($this->_ci->session->userdata('access_token'))
		{
		
			try
			{
			
				$ch = curl_init($this->_ci->config->item('orbital_core_location') . $target);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: Bearer ' . base64_encode($this->_ci->session->userdata('access_token'))));
				
				if ($output = curl_exec($ch))
				{
					// Response OK, content all good!
					curl_close($ch);
					return json_decode($output);
				}
				else
				{
					// Something has gone wrong - try figure out what.
					$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);
					
					// Different behaviours for unauthorised code
					if ($http_status === 401)
					{
						// Unauthorised response - token invalid/expired/revoked. Try to refresh.
						echo '401 Attempt Refresh';
					}
					else
					{
						// Something else has gone wrong. Try to parse it out.
						if ($response = json_decode($output) && isset($response->error))
						{
							// Load error view with given error message
							$this->_ci->parser->parse('includes/header', $this->data);
							$this->_ci->parser->parse('static/error', $this->data);
							$this->_ci->parser->parse('includes/footer', $this->data);
							return FALSE;
						}
						else
						{
							// Load error view with own message.
							$this->_ci->parser->parse('includes/header', $this->data);
							$this->_ci->parser->parse('static/error', $this->data);
							$this->_ci->parser->parse('includes/footer', $this->data);
							return FALSE;
						}
					}
				}
			}
			catch (Exception $e)
			{
				return FALSE;
			}
			
		}
		else
		{
			// No user is present, thus we have no access token. Send user to sign in.
			redirect('signin');
		}
	
	}

	/**
	 * Get (Unauthenticated)
	 *
	 * Performs an unauthenticated HTTP GET against Orbital Core.
	 *
	 * @access private
	 *
	 * @param string $target Core resource to GET.
	 *
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

	private function get_unauthed($target)
	{
	
		try
		{
			return json_decode(file_get_contents($this->_ci->config->item('orbital_core_location') . $target));
		}
		catch (Exception $e)
		{
			return FALSE;
		}
	
	}

	/**
	 * Core: Ping
	 *
	 * Gets the current status of the Core.
	 *
	 * @access public
	 *
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

    public function core_ping()
    {
    
    	return $this->get_unauthed('core/ping');
    
    }
    
    /**
	 * Core: Authentication Types
	 *
	 * Gets all valid authentication routes for the Core.
	 *
	 * @access public
	 *
	 * @return object|FALSE Object if successful, FALSE if not.
	 */
    
    public function core_auth_types()
    {
    
    	return $this->get_unauthed('core/auth_types');
    
    }
    
    /**
	 * User: Details
	 *
	 * Retrieves details for the specified user, or the current user if none
	 * is specified.
	 *
	 * @access public
	 *
	 * @param string $user The email address of the user to query.
	 *
	 * @return object|FALSE Object if successful, FALSE if not.
	 */
    
    public function user_details($user = NULL)
    {
    
    	if ($user === NULL)
    	{
    		return $this->get_authed('user/details');
    	}
    	else
    	{
    		return $this->get_authed('user/details?user=' . urlencode($user));
    	}
    
    }
}

/* End of file Orbital.php */