<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sign In Controller
 *
 * Marshalls sign-in requests to the appropriate Core URI
 *
 * @category   Controller
 * @package    Orbital
 * @subpackage Manager
 * @author     Nick Jackson <nijackson@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
*/

class Signin extends CI_Controller {

	/**
	 * Data to be passed to the views
	*/
	
	private $data = array();
	
	/**
	 * Scopes to be requested from Orbital Core
	*/
	
	private $request_scopes = array(
		'access',
		'administration',
		'archivefiles_read',
		'archivefiles_write',
		'projects',
		'create_projects'
	);

	/**
	 * Constructor
	*/

	function __construct()
	{
		parent::__construct();
		
		$this->data = $this->orbital->common_content();
	}

	/**
	 * Sign In
	 *
	 * Directs user to sign-in method selection.
	 * @return NULL
	 */

	function index()
	{
	
		if ($auth_types = $this->orbital->core_auth_types())
		{
		
			// Generate the sign-in instance token (help prevent CSRF)
			$this->session->set_userdata('signin_token', uniqid());
			
			if ($this->input->get('destination'))
			{
				$destination = $this->input->get('destination');
			}
			else
			{
				$destination = 'projects';
			}
			
			foreach ($auth_types->response->auth_types as $auth_type)
			{
				$this->data['auth_types'][] = array(
					'name' => $auth_type->name,
					'uri' => $auth_type->uri  . '?response_type=code&scope=' . implode(' ', $this->request_scopes) . '&client_id=' . $this->config->item('orbital_app_id') . '&redirect_uri=' . site_url('signin/auth') . '&state=' . urlencode(serialize(array('token' => $this->session->userdata('signin_token'), 'destination' => $destination, 'handler' => $auth_type->tag)))
				);
			}
			
			$this->data['page_title'] = 'Sign In';
		
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('user/signin', $this->data);
			$this->parser->parse('includes/footer', $this->data);
			
		}
		else
		{
			// Error, load the error view up
			$this->data['page_title'] = 'Problem Signing In';
			$this->data['error_title'] = 'Problem Signing In';
			$this->data['error_text'] = 'There has been a problem starting the sign-in process. Sorry about that.';
			$this->data['error_technical'] = 'no_auth_response: Orbital Core did not respond with a valid list of authentication methods.';
			
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('static/error', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		}
	}
	
	/**
	 * Authentication Callback
	 *
	 * Accepts returning authentication sessions from Core and performs token
	 * swap.
	 * @return NULL
	 */
	
	function auth()
	{
	
		if ($this->input->get('state'))
		{
			$state = unserialize(urldecode($this->input->get('state')));
	
			// Check that the state variable is as expected for the session
			if (isset($state['token']) AND $state['token'] === $this->session->userdata('signin_token'))
			{
		
				// Unset signin token
				$this->session->unset_userdata('signin_token');
		
				// Make sure there is no error before continuing
				if ($this->input->get('error'))
				{
				
					// Error, load the error view up
					$this->data['page_title'] = 'Sign-In Error';
					$this->data['error_title'] = 'Sign-In Error';
					$this->data['error_text'] = 'An error has occured during sign-in.';
					$this->data['error_technical'] = 'oauth:' . $this->input-get('error') . ': ' . $this->input-get('error_description');
					
					$this->parser->parse('includes/header', $this->data);
					$this->parser->parse('static/error', $this->data);
					$this->parser->parse('includes/footer', $this->data);
				
				}
				else
				{
				
					// No error, begin further magic!
					
					// Ensure we have a code, OR else abort
					if ($this->input->get('code'))
					{
					
						// Code present, try swap it
						
						// Go complete the flow!				
						$postfields = 'grant_type=authorization_code&code=' . $this->input->get('code');
						$c = curl_init();
						curl_setopt($c, CURLOPT_URL, $this->config->item('orbital_core_location') . 'auth/access_token');
						curl_setopt($c, CURLOPT_POST, TRUE);
						curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
						if (ENVIRONMENT === 'development')
						{
							curl_setopt($c, CURLOPT_SSL_VERIFYPEER, FALSE);
						}
						curl_setopt($c, CURLOPT_POSTFIELDS, $postfields);
						curl_setopt($c, CURLOPT_USERPWD, $this->config->item('orbital_app_id') . ':' . $this->config->item('orbital_app_secret'));
						$reply = curl_exec($c);	
						curl_close ($c);
						
						$response = json_decode($reply);
						
						if ( ! isset($response->error) AND isset($response->access_token) AND isset($response->token_type) AND isset($response->expires_in) AND isset($response->refresh_token) AND isset($response->scope) AND isset($response->user))
						{
							// Sign in has gone smoothly and we have all expected fields. Load up user details to the session!
							
							$this->session->set_userdata(array(
								'current_user_string' => $response->user,
								'access_token' => $response->access_token,
								'refresh_token' => $response->refresh_token,
								'system_admin' => $response->system_admin,
								'signin_handler' => $state['handler']
							));
							
							$this->session->set_flashdata('message', 'Signed in successfully. Welcome to Orbital!');
							$this->session->set_flashdata('message_type', 'success');
							
							if (isset($state['destination']))
							{
								redirect($state['destination']);
							}
							else
							{
								redirect();
							}
							
						}
						else
						{
						
							if (isset($response->error))
							{
								$this->data['page_title'] = 'Sign-In Error';
								$this->data['error_title'] = 'Sign-In Error';
								$this->data['error_text'] = 'An error has occured during sign-in.';
								$this->data['error_technical'] = 'oauth:' . $response->error . ': ' . $response->error_description;
							}
							else
							{
							
								$this->data['page_title'] = 'Sign-In Error';
								$this->data['error_title'] = 'Sign-In Error';
								$this->data['error_text'] = 'An error has occured during sign-in.';
								$this->data['error_technical'] = 'missing_oauth_response: Some required elements were missing from the OAuth response.';
	
							}
								
							$this->parser->parse('includes/header', $this->data);
							$this->parser->parse('static/error', $this->data);
							$this->parser->parse('includes/footer', $this->data);
						}
					
					}
					else
					{
					
						$this->data['page_title'] = 'Sign-In Error';
						$this->data['error_title'] = 'Sign-In Error';
						$this->data['error_text'] = 'An error has occured during sign-in.';
						$this->data['error_technical'] = 'missing_code: Attempted redirect to callback without code present';
						
						$this->parser->parse('includes/header', $this->data);
						$this->parser->parse('static/error', $this->data);
						$this->parser->parse('includes/footer', $this->data);
					
					}
				
				}
				
			}
			else
			{
			
				// Sign-in token does not match OR state not present. Abort.
				
				$this->data['page_title'] = 'Sign-In Error';
				$this->data['error_title'] = 'Sign-In Error';
				$this->data['error_text'] = 'An error has occured during sign-in.';
				$this->data['error_technical'] = 'invalid_signin_token: The sign-in token was not present in the state, OR did not match the expected value.';
				
				$this->parser->parse('includes/header', $this->data);
				$this->parser->parse('static/error', $this->data);
				$this->parser->parse('includes/footer', $this->data);
			
			}
			
		}
		else
		{
		
			// Sign-in token does not match OR state not present. Abort.
			
			$this->data['page_title'] = 'Sign-In Error';
			$this->data['error_title'] = 'Sign-In Error';
			$this->data['error_text'] = 'An error has occured during sign-in.';
			$this->data['error_technical'] = 'invalid_signin_token: The state variable was not provided.';
			
			$this->parser->parse('includes/header', $this->data);
			$this->parser->parse('static/error', $this->data);
			$this->parser->parse('includes/footer', $this->data);
		
		}
	
	}
	
	/**
	 * Sign Out
	 *
	 * Destroys user session and redirects to home page.
	 * @return NULL
	 */
	
	function signout()
	{
		$this->session->sess_destroy();
		if ($this->session->userdata('signin_handler'))
		{
			header('Location: ' . $this->config->item('orbital_core_location') . 'auth/signout/' . $this->session->userdata('signin_handler'));
		}
		else
		{
			redirect();
		}
	}
		
}

// End of file signin.php
// Location: ./controllers/signin.php