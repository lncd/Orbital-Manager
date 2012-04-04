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

	private $data;

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

			if ($this->_ci->session->userdata('system_admin'))
			{
				$common_content['nav_menu'][] = array (
					'name' => 'Administration',
					'uri' => site_url('admin')
				);
			}

		}

		$this->data = $common_content;
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
		curl_setopt($ch, CURLOPT_URL, $this->_ci->config->item('orbital_core_location') . 'auth/refresh_token');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if (ENVIRONMENT === 'development') { curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); }
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_USERPWD, $this->_ci->config->item('orbital_app_id') . ':' . $this->_ci->config->item('orbital_app_secret'));
		if ($reply = curl_exec($ch))
		{
			$response = json_decode($reply);

			if (!isset($response->error) && isset($response->access_token) && isset($response->token_type) && isset($response->expires_in) && isset($response->refresh_token) && isset($response->scope) && isset($response->user))
			{
				$this->_ci->session->set_userdata(array(
						'current_user_string' => $response->user,
						'access_token' => $response->access_token,
						'refresh_token' => $response->refresh_token,
						'system_admin' => $response->system_admin
					));
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			// Failed. Abort.
			return FALSE;
		}

		curl_close($ch);
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
	 * @return object|FALSE An object representing the request result, or
	 *                      FALSE on a request failure.
	 */

	private function get_authed($target)
	{

		if ($this->_ci->session->userdata('access_token'))
		{

			try
			{

				$ch = curl_init($this->_ci->config->item('orbital_core_location') . $target);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				if (ENVIRONMENT === 'development') { curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); }
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
					echo $http_status;
					curl_close($ch);

					// Different behaviours for unauthorised code
					if ($http_status === 401)
					{
						// Unauthorised response - token invalid/expired/revoked. Try to refresh, and run again
						if ($this->refresh_token($this->_ci->session->userdata('refresh_token')))
						{
							return $this->get_authed($target);
						}
						else
						{

							$this->data['page_title'] = 'Authentication Error';
							$this->data['error_title'] = 'Authentication Error';
							$this->data['error_text'] = 'There has been a problem authenticating this request.';
							$this->data['error_technical'] = 'refresh_failure: Unable to refresh access token.';

							// Refresh failed. Abort.
							$this->_ci->parser->parse('includes/header', $this->data);
							$this->_ci->parser->parse('static/error', $this->data);
							$this->_ci->parser->parse('includes/footer', $this->data);
							return FALSE;
						}
					}
					else
					{
						// Something else has gone wrong. Try to parse it out.
						if ($response = json_decode($output) && isset($response->error))
						{

							$this->data['page_title'] = 'Authentication Error';
							$this->data['error_title'] = 'Authentication Error';
							$this->data['error_text'] = 'There has been a problem authenticating this request.';
							$this->data['error_technical'] = 'oauth_401: ' . $response->error . ': ' . $response->error_description;

							// Load error view with given error message
							$this->_ci->parser->parse('includes/header', $this->data);
							$this->_ci->parser->parse('static/error', $this->data);
							$this->_ci->parser->parse('includes/footer', $this->data);
							return FALSE;
						}
						else
						{

							$this->data['page_title'] = 'Authentication Error';
							$this->data['error_title'] = 'Authentication Error';
							$this->data['error_text'] = 'There has been a problem authenticating this request.';
							$this->data['error_technical'] = 'oauth_401_generic: Core issued a HTTP 401 during authentication.';

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
	
	private function post_authed($target, $post_fields)
	{

		if ($this->_ci->session->userdata('access_token'))
		{
			try
			{
				$ch = curl_init($this->_ci->config->item('orbital_core_location') . $target);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				if (ENVIRONMENT === 'development') { curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); }
				curl_setopt($ch,CURLOPT_HTTPHEADER,array('Authorization: Bearer ' . base64_encode($this->_ci->session->userdata('access_token'))));
				curl_setopt($ch, CURLOPT_POST, TRUE);
				
				$postfields = '';
				
				foreach ($post_fields as $fieldname => $fieldvalue)
				{
					$postfields .= $fieldname . '=' . urlencode($fieldvalue);
				}

				curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $postfields);
		
		
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
					echo $http_status;
					curl_close($ch);

					// Different behaviours for unauthorised code
					if ($http_status === 401)
					{
						// Unauthorised response - token invalid/expired/revoked. Try to refresh, and run again
						if ($this->refresh_token($this->_ci->session->userdata('refresh_token')))
						{
							return $this->get_authed($target);
						}
						else
						{

							$this->data['page_title'] = 'Authentication Error';
							$this->data['error_title'] = 'Authentication Error';
							$this->data['error_text'] = 'There has been a problem authenticating this request.';
							$this->data['error_technical'] = 'refresh_failure: Unable to refresh access token.';

							// Refresh failed. Abort.
							$this->_ci->parser->parse('includes/header', $this->data);
							$this->_ci->parser->parse('static/error', $this->data);
							$this->_ci->parser->parse('includes/footer', $this->data);
							return FALSE;
						}
					}
					else
					{
						// Something else has gone wrong. Try to parse it out.
						if ($response = json_decode($output) && isset($response->error))
						{

							$this->data['page_title'] = 'Authentication Error';
							$this->data['error_title'] = 'Authentication Error';
							$this->data['error_text'] = 'There has been a problem authenticating this request.';
							$this->data['error_technical'] = 'oauth_401: ' . $response->error . ': ' . $response->error_description;

							// Load error view with given error message
							$this->_ci->parser->parse('includes/header', $this->data);
							$this->_ci->parser->parse('static/error', $this->data);
							$this->_ci->parser->parse('includes/footer', $this->data);
							return FALSE;
						}
						else
						{

							$this->data['page_title'] = 'Authentication Error';
							$this->data['error_title'] = 'Authentication Error';
							$this->data['error_text'] = 'There has been a problem authenticating this request.';
							$this->data['error_technical'] = 'oauth_401_generic: Core issued a HTTP 401 during authentication.';

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
			return json_decode(@file_get_contents($this->_ci->config->item('orbital_core_location') . $target));
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
	 * Core: Database Server Status
	 *
	 * Returns the status of the connected Mongo server.
	 *
	 * @access public
	 *
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

	public function core_server_status()
	{

		return $this->get_authed('core/mongo_server_status');

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

	public function projects_list($user = NULL)
	{

		if ($user === NULL)
		{
			return $this->get_authed('projects');
		}
		else
		{
			return $this->get_authed('projects?user=' . urlencode($user));
		}
	}

	public function project_details($project)
	{
		return $this->get_authed('project/' .$project);
	}
}

/* End of file Orbital.php */