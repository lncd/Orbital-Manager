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

	/**
	 * CodeIgniter Instance.
	 *
	 * @var $_ci 
	 */

	private $_ci;
	
	/**
	 * Constructor
	 */

	function __construct()
	{
		$this->_ci =& get_instance();
	}
	
	/**
	 * Builds the content common to every page
	 *
	 *@return ARRAY
	 */

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
			$common_content['user_presence'] = lang('navigation_signed_in') . '<a href="' . site_url('me') . '">' . $this->_ci->session->userdata('current_user_string') . '</a> &middot; <a href="' . site_url('signout') . '">' . lang('navigation_sign_out') . '</a>';
		}
		else
		{
			$common_content['user_presence'] = '<a href="' . site_url('signin') . '">' . lang('navigation_sign_in') . '</a>';
		}

		$common_content['nav_menu'] = array();

		if ($this->_ci->session->userdata('current_user_string'))
		{

			$common_content['nav_menu'][] = array (
				'name' => 'Your Projects',
				'uri' => site_url('projects')
			);

			$common_content['nav_menu'][] = array (
				'name' => 'Your Profile',
				'uri' => site_url('profile')
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
	 * Swaps a refresh token for a new access token AND refresh token, and
	 * stores in the session
	 *
	 * @param string $token Token to swap.
	 *
	 * @access public
	 * @return bool TRUE if swap successful, FALSE if not.
	 */

	public function refresh_token($token)
	{

		$postfields = 'grant_type=refresh_token&refresh_token=' . $token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_ci->config->item('orbital_core_location') . 'auth/refresh_token');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if (ENVIRONMENT === 'development')
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		}
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_USERPWD, $this->_ci->config->item('orbital_app_id') . ':' . $this->_ci->config->item('orbital_app_secret'));
		if ($reply = curl_exec($ch))
		{
			$response = json_decode($reply);

			if ( ! isset($response->error) AND isset($response->access_token) AND isset($response->token_type) AND isset($response->expires_in) AND isset($response->refresh_token) AND isset($response->scope) AND isset($response->user))
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
	 * @param array $target Scopes to ensure that the user has access to.
	 *
	 * @access private
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
				if (ENVIRONMENT === 'development')
				{
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				}
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . base64_encode($this->_ci->session->userdata('access_token'))));

				if ($output = curl_exec($ch))
				{
					// Response OK, content all good!
					curl_close($ch);
					if($return = json_decode($output))
					{
						return $return;
					}
					else
					{
						$this->data['page_title'] = 'Parsing Error';
						$this->data['error_title'] = 'Invalid Response';
						$this->data['error_text'] = 'Orbitla Core has not returned a valid reponse.';
						$this->data['error_technical'] = 'invalid_reponse: Orbital returned an invalid response.<br>' . $output;
						// Refresh failed. Abort.
						$this->_ci->parser->parse('includes/header', $this->data);
						$this->_ci->parser->parse('static/error', $this->data);
						$this->_ci->parser->parse('includes/footer', $this->data);
						return FALSE;
					}
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
						// Unauthorised response - token invalid/expired/revoked. Try to refresh, AND run again
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
						if ($response = json_decode($output) AND isset($response->error))
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
				$this->data['page_title'] = 'Unknown Error';
				$this->data['error_title'] = 'Unknown Error';
				$this->data['error_text'] = 'Something has gone wrong.';
				$this->data['error_technical'] = $e->getMessage();
				// Load error view with own message.
				$this->_ci->parser->parse('includes/header', $this->data);
				$this->_ci->parser->parse('static/error', $this->data);
				$this->_ci->parser->parse('includes/footer', $this->data);

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
	 * Post method, Authenticated
	 *
	 * Sends an authenticated POST request
	 *
	 * @param string $target      Target of HTTP POST.
	 * @param array  $post_fields Contents of HTTP POST.
	 *
	 * @return bool TRUE if swap successful, FALSE if not.
	 */

	private function post_authed($target, $post_fields)
	{

		if ($this->_ci->session->userdata('access_token'))
		{
			try
			{
				$ch = curl_init($this->_ci->config->item('orbital_core_location') . $target);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				if (ENVIRONMENT === 'development')
				{
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				}
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . base64_encode($this->_ci->session->userdata('access_token'))));
				curl_setopt($ch, CURLOPT_POST, TRUE);

				$postfields = array();

				foreach ($post_fields as $fieldname => $fieldvalue)
				{
					$postfields[] = $fieldname . '=' . urlencode($fieldvalue);
				}

				curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $postfields));


				if ($output = curl_exec($ch))
				{
					// Response OK, content all good!
					curl_close($ch);
					if($return = json_decode($output))
					{
						return $return;
					}
					else
					{
						$this->data['page_title'] = 'Parsing Error';
						$this->data['error_title'] = 'Invalid Response';
						$this->data['error_text'] = 'Orbitla Core has not returned a valid reponse.';
						$this->data['error_technical'] = 'invalid_reponse: Orbital returned an invalid response.<br>' . $output;
						// Refresh failed. Abort.
						$this->_ci->parser->parse('includes/header', $this->data);
						$this->_ci->parser->parse('static/error', $this->data);
						$this->_ci->parser->parse('includes/footer', $this->data);
						return FALSE;
					}
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
						// Unauthorised response - token invalid/expired/revoked. Try to refresh, AND run again
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
						if ($response = json_decode($output) AND isset($response->error))
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
				$this->data['page_title'] = 'Unknown Error';
				$this->data['error_title'] = 'Unknown Error';
				$this->data['error_text'] = 'Something has gone wrong.';
				$this->data['error_technical'] = $e->getMessage();
				// Load error view with own message.
				$this->_ci->parser->parse('includes/header', $this->data);
				$this->_ci->parser->parse('static/error', $this->data);
				$this->_ci->parser->parse('includes/footer', $this->data);

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
	 * Put (Authenticated)
	 *
	 * @param string $target      Target of HTTP PUT.
	 * @param array  $post_fields Contents of HTTP PUT.
	 *
	 * @return bool TRUE if swap successful, FALSE if not.
	 */

	private function put_authed($target, $post_fields)
	{

		if ($this->_ci->session->userdata('access_token'))
		{
			try
			{
				$ch = curl_init($this->_ci->config->item('orbital_core_location') . $target);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				if (ENVIRONMENT === 'development')
				{
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				}
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . base64_encode($this->_ci->session->userdata('access_token'))));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

				$postfields = array();

				foreach ($post_fields as $fieldname => $fieldvalue)
				{
					$postfields[] .= $fieldname . '=' . urlencode($fieldvalue);
				}

				curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $postfields));


				if ($output = curl_exec($ch))
				{
					// Response OK, content all good!
					curl_close($ch);
					if($return = json_decode($output))
					{
						return $return;
					}
					else
					{
						$this->data['page_title'] = 'Parsing Error';
						$this->data['error_title'] = 'Invalid Response';
						$this->data['error_text'] = 'Orbitla Core has not returned a valid reponse.';
						$this->data['error_technical'] = 'invalid_reponse: Orbital returned an invalid response.<br>' . $output;
						// Refresh failed. Abort.
						$this->_ci->parser->parse('includes/header', $this->data);
						$this->_ci->parser->parse('static/error', $this->data);
						$this->_ci->parser->parse('includes/footer', $this->data);
						return FALSE;
					}
				}
				else
				{
					// Something has gone wrong - try figure out what.
					$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);

					// Different behaviours for unauthorised code
					if ($http_status === 401)
					{
						// Unauthorised response - token invalid/expired/revoked. Try to refresh, AND run again
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
						if ($response = json_decode($output) AND isset($response->error))
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
				$this->data['page_title'] = 'Unknown Error';
				$this->data['error_title'] = 'Unknown Error';
				$this->data['error_text'] = 'Something has gone wrong.';
				$this->data['error_technical'] = $e->getMessage();
				// Load error view with own message.
				$this->_ci->parser->parse('includes/header', $this->data);
				$this->_ci->parser->parse('static/error', $this->data);
				$this->_ci->parser->parse('includes/footer', $this->data);

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
	 * Delete (Authenticated)
	 *
	 * Performs an authenticated HTTP DELETE against Orbital Core.
	 *
	 * @param string $target Core resource to DELETE.
	 *
	 * @access private
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

	private function delete_authed($target)
	{
		if ($this->_ci->session->userdata('access_token'))
		{
			try
			{
				$ch = curl_init($this->_ci->config->item('orbital_core_location') . $target);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				if (ENVIRONMENT === 'development')
				{
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				}
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . base64_encode($this->_ci->session->userdata('access_token'))));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

				if ($output = curl_exec($ch))
				{
					// Response OK, content all good!
					curl_close($ch);
					if($return = json_decode($output))
					{
						return $return;
					}
					else
					{
						$this->data['page_title'] = 'Parsing Error';
						$this->data['error_title'] = 'Invalid Response';
						$this->data['error_text'] = 'Orbital Core has not returned a valid response.';
						$this->data['error_technical'] = 'invalid_response: Orbital returned an invalid response.<br>' . $output;
						// Refresh failed. Abort.
						$this->_ci->parser->parse('includes/header', $this->data);
						$this->_ci->parser->parse('static/error', $this->data);
						$this->_ci->parser->parse('includes/footer', $this->data);
						return FALSE;
					}
				}
				else
				{
					// Something has gone wrong - try figure out what.
					$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);

					// Different behaviours for unauthorised code
					if ($http_status === 401)
					{
						// Unauthorised response - token invalid/expired/revoked. Try to refresh, AND run again
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
						if ($response = json_decode($output) AND isset($response->error))
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
				$this->data['page_title'] = 'Unknown Error';
				$this->data['error_title'] = 'Unknown Error';
				$this->data['error_text'] = 'Something has gone wrong.';
				$this->data['error_technical'] = $e->getMessage();
				// Load error view with own message.
				$this->_ci->parser->parse('includes/header', $this->data);
				$this->_ci->parser->parse('static/error', $this->data);
				$this->_ci->parser->parse('includes/footer', $this->data);

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
	 * @param array $target Scopes to ensure that the user has access to.
	 *
	 * @access private
	 * @return object|FALSE An object representing the request result, or
	 *                      FALSE on a request failure.
	 */

	private function get_unauthed($target)
	{

		try
		{
			return json_decode(@file_get_contents($this->_ci->config->item('orbital_core_location') . $target));
		}
		catch (Exception $e)
		{
			$this->data['page_title'] = 'Parsing Error';
			$this->data['error_title'] = 'Invalid Response';
			$this->data['error_text'] = 'Orbitla Core has not returned a valid reponse.';
			$this->data['error_technical'] = 'invalid_reponse: Orbital returned an invalid response.';
			// Refresh failed. Abort.
			$this->_ci->parser->parse('includes/header', $this->data);
			$this->_ci->parser->parse('static/error', $this->data);
			$this->_ci->parser->parse('includes/footer', $this->data);
			return FALSE;
		}
	}

	/**
	 * Core: Ping
	 *
	 * Gets the current status of the Core.
	 *
	 * @access public
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
	 * User Details
	 *
	 * Retrieves details for the specified user, OR the current user if none
	 * is specified.
	 *
	 * @param string $user The email address of the user to query.
	 *
	 * @access public	
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

	/**
	 * Projects list
	 *
	 * Retrieves list of projects for the specified user, OR the current user if none
	 * is specified.
	 *
	 * @param string $user The email address of the user to query.
	 *
	 * @access public
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

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
	
	/**
	 * Public projects list
	 *
	 * Retrieves list of public projects up to the specified limit
	 *
	 * @param int $limit The limit to the number of public projects to display.
	 *
	 * @access public
	 * @return ARRAY.
	 */

	public function projects_public_list($limit = 20)
	{
		return $this->get_unauthed('projects/public?limit=' . $limit);
	}

	/**
	 * Project details
	 *
	 * Retrieves project details
	 *
	 * @param int $project The project to return the details of.
	 *
	 * @access public	
	 * @return ARRAY.
	 */

	public function project_details($project, $limit = NULL)
	{
		return $this->get_authed('project/' . $project . '?limit=' . $limit);
	}

	/**
	 * Project public details
	 *
	 * Retrieves public project details
	 *
	 * @param int $project The project to return the details of.	
	 *
	 * @access public
	 * @return ARRAY.
	 */

	public function project_public_details($project, $limit = NULL)
	{
		return $this->get_unauthed('project/' . $project . '/public' . '?limit=' . $limit);
	}

	/**
	 * Create project
	 *
	 * creates a new project
	 *
	 * @param int $name     The name of the new project.
	 * @param int $abstract The abstract of the new project.
	 *
	 * @access public
	 * @return object.
	 */

	public function create_project($name, $abstract)
	{
		return $this->post_authed('projects/create', array('name' => $name, 'abstract' => $abstract));
	}

	/**
	 * Update project
	 *
	 * creates a new project
	 *
	 * @param string $identifier       The identifier of the project.
	 * @param string $name             The project name.
	 * @param string $abstract         The project abstract.	
	 * @param string $research_group   The research group the project is part of.
	 * @param int    $start_date       The start date of the project.
	 * @param int    $end_date         The end date of the new project.
	 * @param string $default_licence  The licence the project is published under.
	 * @param bool   $public_view      If the project is publically accessible or not.
	 * @param string $google_analytics The property ID of the project for Google analytics.
	 * @access public
	 * @return object.
	 */

	public function project_update($identifier, $name, $abstract, $research_group, $start_date, $end_date, $default_licence, $public_view, $google_analytics)
	{
		return $this->put_authed('project/' . $identifier, array('name' => $name, 'abstract' => $abstract, 'research_group' => $research_group, 'start_date' => $start_date, 'end_date' => $end_date, 'default_licence' => $default_licence, 'public_view' => $public_view, 'google_analytics' => $google_analytics));
	}

	/**
	 * Delete project
	 *
	 * deletes a project
	 *
	 * @access public
	 * @param $identifier string The identifier of the project.
	 *
	 * @return BOOL.
	 */

	public function delete_project($identifier)
	{
		return $this->delete_authed('project/' . $identifier);
	}
	
	/**
	 * Add Comment to Timeline
	 *
	 * Adds a comment to a project timeline
	 *
	 * @param string $project The ID of the project.
	 * @param string $comment The comment to add to the timeline.
	 *
	 * @access public
	 * @return object.
	 */

	public function timeline_add_comment($project, $comment)
	{
		return $this->post_authed('timeline/comment', array('project' => $project, 'comment' => $comment));
	}
	
	/**
	 * Add Event to Timeline
	 *
	 * Adds an event to a project timeline
	 *
	 * @param string $project The ID of the project.
	 * @param string $comment The event to add to the timeline.
	 * @param string $date    The time to add to the timeline.
	 *
	 * @access public
	 * @return object.
	 */

	public function timeline_add_event($project, $event, $start_date, $end_date = NULL, $publicity)
	{
		return $this->post_authed('timeline/event', array('project' => $project, 'event' => $event, 'start_date' => $start_date, 'end_date' => $end_date, 'publicity' => $publicity));
	}


	/**
	 * Licences: List
	 *
	 * Returns a list of all licences.
	 *
	 * @access public
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

	public function licences_list()
	{
		return $this->get_authed('licences');
	}

	/**
	 * Licences: Enabled List
	 *
	 * Returns a list of all enabled licences.
	 *
	 * @access public
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

	public function licences_enabled_list()
	{
		return $this->get_unauthed('licences/enabled');
	}

	/**
	 * Licence: Get
	 *
	 * Returns a licence.
	 *
	 * @access public
	 * @param string $id The identifier of the licence
	 * @return object|FALSE Object if successful, FALSE if not.
	 */

	public function licence_get($id)
	{
		return $this->get_unauthed('licence/' . $id);
	}
	
	/**
	 * Licence: Create
	 *
	 * Creates a licence.
	 *
	 * @param string $name      The name of the licence
	 * @param string $shortname The short name of the licence
	 * @param string $uri       The uri of the licence
	 *
	 * @access public
	 * @return BOOL.
	 */

	public function licence_create($name, $shortname, $uri, $allow, $forbid, $condition)
	{
		return $this->post_authed('licences', array('name' => $name, 'shortname' => $shortname, 'uri' => $uri, 'allow' => $allow, 'forbid' => $forbid, 'condition' => $condition));
	}

	/**
	 * Licence: Update
	 *
	 * Updates a licence.
	 *
	 * @access public
	 * @param string $id        The licence identifier
	 * @param string $shortname The short name of the licence
	 * @param string $uri       The uri of the licence
	 * @param bool $enabled     The uri of the licence
	 *
	 * @return BOOL.
	 */

	public function licence_update($id, $name, $shortname, $uri, $allow, $forbid, $condition, $enable = FALSE)
	{
		return $this->post_authed('licence/' . $id, array('name' => $name, 'shortname' => $shortname, 'uri' => $uri, 'allow' => $allow, 'forbid' => $forbid, 'condition' => $condition, 'enable' => $enable));
	}
	
	/**
	 * Licence: Delete
	 *
	 * Deletes a licence.
	 *
	 * @param string $id The ID of the licence
	 *
	 * @access public
	 * @return BOOL.
	 */

	public function licence_delete($id)
	{
		return $this->delete_authed('licence/' . $id);
	}
	
	/**
	 * Get OTK
	 *
	 * Gets a One time key.
	 *
	 * @access public
	 * @param string $file_id The identifier of the file the user wants access to
	 *
	 * @return object.
	 */

	public function get_otk($file_id)
	{
		if ($this->_ci->session->userdata('current_user_string'))
		{
			return $this->get_authed('file/' . $file_id . '/get_otk');
		}
		else
		{
			return $this->get_unauthed('file/' . $file_id . '/get_otk');
		}
	}
	
	/**
	 * File get details
	 *
	 * Gets the details of a file
	 *
	 * @access public
	 * @param $file_id string The identifier of the file the user wants access to
	 *
	 * @return object.
	 */

	public function file_get_details($file_id)
	{
		return $this->get_authed('file/' . $file_id);
	}
	
	/**
	 * File get details public
	 *
	 * Gets the details of a public file
	 *
	 * @access public
	 * @param $file_id string The identifier of the file set the user wants access to
	 *
	 * @return object.
	 */
	 
	public function file_get_details_public($file_id)
	{
		return $this->get_unauthed('file/' . $file_id . '/public');	
	}
	
	/**
	 * File set get details
	 *
	 * Gets the details of a file set
	 *
	 * @access public
	 * @param $file_id string The identifier of the file set the user wants access to
	 *
	 * @return object.
	 */

	public function delete_file($identifier)
	{
		return $this->delete_authed('file/' . $identifier . '/delete');	
	}
	
	public function delete_file_set($identifier)
	{
		return $this->delete_authed('file_set/' . $identifier . '/delete');	
	}
	
	public function file_set_get_details($file_id)
	{
		return $this->get_authed('file_set/' . $file_id);
	}
	
	/**
	 * File set get details public
	 *
	 * Gets the details of a public file set
	 *
	 * @access public
	 * @param $file_id string The identifier of the file set the user wants access to
	 *
	 * @return object.
	 */

	public function file_set_get_details_public($file_id)
	{
		return $this->get_authed('file_set/' . $file_id . '/public');
	}
	
	


	/**
	 * Create file set
	 *
	 * creates a new file set for a project
	 *
	 * @param int $identifier The id of the project the file set belongs to.
	 * @param int $name       The name of the new project.
	 * @param int $abstract   The abstract of the new project.
	 *
	 * @access public
	 * @return object.
	 */

	public function create_new_file_set($identifier, $name, $abstract)
	{
		return $this->post_authed('file_set/create', array('identifier' => $identifier, 'name' => $name, 'abstract' => $abstract));
	}
	
	/**
	 * File set update
	 *
	 * Updates the details of a file set
	 *
	 * @access public
	 * @param $file_id string The identifier of the file set the user wants access to
	 *
	 * @return object.
	 */

	public function file_set_update($identifier, $name, $description, $file_set_public, $project_identifier)
	{
		return $this->put_authed('file_set/' . $identifier, array('name' => $name, 'description' => $description, 'project_identifier' => $project_identifier, 'file_set_public' => $file_set_public));
	}
	
	public function file_set_update_files($identifier, $file, $action)
	{
		return $this->put_authed('file_set_files/' . $identifier, array('file' => $file, 'action' => $action));
	}
	
	public function file_update_file_sets($identifier, $file_set, $action)
	{
		return $this->put_authed('file_file_sets/' . $identifier, array('file_set' => $file_set, 'action' => $action));
	}
	
	/**
	 * Update file details
	 *
	 * updates a files details
	 *
	 * @param string $identifier       The identifier of the file.
	 * @param string $name             The file name.
	 * @param string $default_licence  The licence the file is published under.
	 * @param bool   $public_view      If the project is publically accessible or not.
	 * @access public
	 * @return object.
	 */

	public function file_update($identifier, $name, $default_licence, $public_view)
	{
		return $this->put_authed('file/' . $identifier, array('name' => $name, 'default_licence' => $default_licence, 'public_view' => $public_view));
	}
	
	public function update_project_member($identifier, $user, $user_perms)
	{
		if (in_array('read', $user_perms))
		{
			$read = 1;
		}
		else
		{
			$read = 0;
		}
		if (in_array('write', $user_perms))
		{
			$write = 1;
		}
		else
		{
			$write = 0;
		}
		if (in_array('delete', $user_perms))
		{
			$delete = 1;
		}
		else
		{
			$delete = 0;
		}
		if (in_array('manage_users', $user_perms))
		{
			$manage_users = 1;
		}
		else
		{
			$manage_users = 0;
		}
		if (in_array('archivefiles_read', $user_perms))
		{
			$archivefiles_read = 1;
		}
		else
		{
			$archivefiles_read = 0;
		}
		if (in_array('archivefiles_write', $user_perms))
		{
			$archivefiles_write = 1;
		}
		else
		{
			$archivefiles_write = 0;
		}
		if (in_array('read', $user_perms))
		{
			$read = 1;
		}
		else
		{
			$read = 0;
		}
		if (in_array('sharedworkspace_read', $user_perms))
		{
			$sharedworkspace_read = 1;
		}
		else
		{
			$sharedworkspace_read = 0;
		}
		if (in_array('dataset_create', $user_perms))
		{
			$dataset_create = 1;
		}
		else
		{
			$dataset_create = 0;
		}
		return $this->put_authed('members/' . $identifier, array('user' => $user, 'read' => $read, 'write' => $write, 'delete' => $delete, 'manage_users' => $manage_users, 'archivefiles_read' => $archivefiles_read, 'archivefiles_write' => $archivefiles_write, 'sharedworkspace_read' => $sharedworkspace_read, 'dataset_create' => $dataset_create));
	}
		
	/**
	 * Deletes project member
	 *
	 * deletes a member from a project
	 *
	 * @param string $identifier       The identifier of the project.
	 * @param string $user             The user to be deleted.
	 * @access public
	 * @return object.
	 */
	
	public function delete_project_member($identifier, $user)
	{
		return $this->delete_authed('project/' . $identifier . '/member/' . urlencode($user));
	}
		
	/**
	 * Create new dataset
	 *
	 * Creates a new dataset
	 *
	 * @param string $project_identifier  The identifier of the project.
	 * @param string $dataset_name        The dataset name.
	 * @param string $dataset_description The dataset description.
	 * @access public
	 * @return object.
	 */
	
	public function create_new_dataset($project_identifier, $dataset_name, $dataset_description)
	{
		return $this->post_authed('dataset/create', array('project_identifier' => $project_identifier, 'dataset_name' => $dataset_name, 'dataset_description' => $dataset_description));
	}
	
		
	/**
	 * Get dataset details
	 *
	 * Gets a datasets details
	 *
	 * @param string $identifier  The identifier of the dataset.
	 * @access public
	 * @return object.
	 */
	
	public function dataset_get_details($identifier)
	{
		return $this->get_authed('dataset/' . $identifier);
	}
		
	/**
	 * Get dataset details
	 *
	 * Gets a datasets details
	 *
	 * @param string $identifier  The identifier of the dataset.
	 * @access public
	 * @return object.
	 */
	
	public function edit_dataset($dataset_id, $dataset_name, $dataset_description, $dataset_visibility, $dataset_licence)
	{
		return $this->post_authed('dataset/' . $dataset_id . '/edit', array('dataset_name' => $dataset_name, 'dataset_description' => $dataset_description, 'dataset_visibility' => $dataset_visibility, 'dataset_licence' => $dataset_licence));
	}
		
				
	/**
	 * Delete dataset
	 *
	 * Deletes a dataset
	 *
	 * @param string $identifier  The identifier of the dataset.
	 * @access public
	 * @return object.
	 */
	
	public function delete_dataset($dataset_identifier)
	{
		return $this->delete_authed('dataset/' . $dataset_identifier . '/delete');
	}
		
	/**
	 * Get query details
	 *
	 * Gets a querys details
	 *
	 * @param string $identifier  The identifier of the query.
	 * @access public
	 * @return object.
	 */
	
	public function query_get_details($query_identifier)
	{
		return $this->get_authed('query/' . $query_identifier);
	}
		
	/**
	 * Build query
	 *
	 * Posts a querys details to MongoDB
	 *
	 * @param string $dataset_id The identifier of the dataset.
	 * @param string $qurty_id   The identifier of the query.
	 *
	 * @access public
	 * @return object.
	 */
	 
	public function update_query($query_id, $query_name, $statements_array, $fields_array)
	{
		return $this->post_authed('query/' . $query_id . '/edit', array('query_name' => $query_name, 'fields' => json_encode($fields_array), 'statements' => json_encode($statements_array)));
	}
	
	public function create_query($dataset_id, $query_name)
	{
		return $this->post_authed('dataset/' . $dataset_id . '/query/new', array('query_name' => $query_name));
	}
	
	public function delete_query($query_id)
	{
		return $this->delete_authed('query/' . $query_id . '/delete');
	}
}

/* End of file Orbital.php */