<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


 function __construct()  {

   parent::__construct();

 }


 function index() {

   $page = 'login';
   if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
     show_404(); // Whoops, we don't have a page for that!
   }
   else {
     $data = array(
       'page_heading' => 'Login',
			 'currentPage' => 'login'
     );
     $this->load->view('templates/header',$data);
     $this->load->view($page,$data);
     $this->load->view('templates/footer',$data);
   }

 }
	
	
	function loginWithGoogle() {
	/*
		require_once APPPATH.'third_party/google-api-php-client-2.1.1/vendor/autoload.php';
		// Get $id_token via HTTPS POST.
		$client = new Google_Client(['client_id' => $CLIENT_ID]);
		$payload = $client->verifyIdToken($id_token);
		if ($payload) {
			$userid = $payload['sub'];
			// If request specified a G Suite domain:
			//$domain = $payload['hd'];
			redirect('home');
		}
		else {
			// Invalid ID token
		}
		*/
		
		// Include two files from google-php-client library in controller
		include_once APPPATH."third_party/google-api-php-client-2.1.1/src/Google/Client.php";
		include_once APPPATH."third_party/google-api-php-client-2.1.1/src/Google/Service/Oauth2.php";

		// Store values in variables from project created in Google Developer Console
		$client_id = '280179834253-f2cqdttlkei6vdu04q8lnlqjh5mt2u6l.apps.googleusercontent.com';
		$client_secret = '38RWxEsoP24-23WLhFpPQ067';
		$redirect_uri = 'http://localhost/ci_google_oauth/';
		$simple_api_key = 'AIzaSyD8g5fnRSZuiZ1HUfIDNnCWLbl3W1kiFqc';

		// Create Client Request to access Google API
		$client = new Google_Client();
		$client->setApplicationName("Delischi");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setDeveloperKey($simple_api_key);
		$client->addScope("https://www.googleapis.com/auth/userinfo.email");
		
		// Send Client Request
		$objOAuthService = new Google_Service_Oauth2($client);
		
		// Start session
		session_start();

		// Add Access Token to Session
		if (isset($_GET['code'])) {
		$client->authenticate($_GET['code']);
		$_SESSION['access_token'] = $client->getAccessToken();
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}

		// Set Access Token to make Request
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
		$client->setAccessToken($_SESSION['access_token']);
		}

		// Get User Data from Google and store them in $data
		if ($client->getAccessToken()) {
			$userData = $objOAuthService->userinfo->get();
			$data['userData'] = $userData;
			$_SESSION['access_token'] = $client->getAccessToken();
		}
		else {
			$authUrl = $client->createAuthUrl();
			$data['authUrl'] = $authUrl;
		}
		// Load view and send values stored in $data
		$this->load->view('google_authentication', $data);

		
	}


 function check_login() {
	 
	 $passes = array (
		 'emailaddress' => $this->input->post('inputEmailLogin'),
		 'pass' => $this->input->post('inputPasswordLogin')
	 );
	 $userLoginTry = $this->user_model->login($passes);
	 
	 if(null == $userLoginTry) { // if email is wrong
		 
		 $this->session->set_flashdata('loginMsg', '<div class="alert alert-danger">Oops! Wrong email address.</div>');
		 redirect('index.php/login');
		 
	 }
	 else {
		 
		 $userLoginTry = (array) $userLoginTry;
		 for($p=0; $p<count($userLoginTry); $p++) {
			 $userLoginTry[$p] = (array) $userLoginTry[$p];
		 }
		 $dbPassEnc = $userLoginTry[0]['encpassword'];
		 $verifiedStatus = $userLoginTry[0]['is_verified'];
		 
		 if($verifiedStatus !== '1') {
			 
			 $this->session->set_tempdata('emailAddressConfirmation', '<div class="alert alert-danger">Your email address has not been verified. Please check your email inbox for an activation email.</div>');
			 redirect('index.php/login');
			 
		 }
		 else {
			 
			 if ( crypt($passes['pass'], $dbPassEnc ) !== $dbPassEnc ) {
			 
				 $this->session->set_flashdata('loginMsg', '<div class="alert alert-danger">Oops! Wrong password.</div>');
				 redirect('index.php/login');

			 }
			 else {

				 $userid = $userLoginTry[0]['userid'];
				 $logged_in_user_details = $this->user_model->get_specific_user($userid);
				 $session_data = array(
					 'logged_in_user_id' => $userid,
					 'usertype' => $logged_in_user_details->usertype,
					 'usertypeid' => $logged_in_user_details->usertypeid,
					 'profile_image' => $logged_in_user_details->imagepath
				 );
				 $this->session->set_userdata($session_data);
				 $this->session->set_flashdata('welcomeMsg', 'Welcome, '.$logged_in_user_details->firstname.'!' );

				 if ($session_data['usertype']=="Administrator") {
					 redirect('index.php/admin/dashboard');
				 }
				 elseif ($session_data['usertype']=="Restaurant Owner") {
					 redirect('index.php/restaurant/dashboard');
				 }
				 else { // if user is customer
					 redirect('index.php/user/profilec');
				 }

			 }
			 
		 }
		 
		 
	 
	 }
	 
 }


}

?>
