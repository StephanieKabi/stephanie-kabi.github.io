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
					 redirect('index.php/user/profilea');
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
