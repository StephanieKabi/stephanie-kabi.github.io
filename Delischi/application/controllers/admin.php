<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {


  public function __construct() {

    parent::__construct();

    function generate_random_salt($input,$cost) { // for update_profile
      $salt = ""; //declare the $salt variable
      $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9)); //generate the 22 random alphanumerics
      for ($i=0; $i < 22; $i++) {
        $salt .= $salt_chars[array_rand($salt_chars)]; //concatenates a random character from $salt_chars to $salt
      }
      return crypt($input, sprintf('$2a$%02d$',$cost).$salt);
    }

  }
	
	
	public function admin_delete_user() {
		if (isset($_GET['uid'])){
			$userid = $_GET['uid'];
      $this->user_model->delete_user($userid);
			redirect('index.php/user/profilea');
    }
	}


  public function dashboard() {
    if(isset($_SESSION['logged_in_user_id'])) {
			
			require_once APPPATH."third_party/vendor/autoload.php";

      $userid = $this->session->userdata('logged_in_user_id');
      $user = $this->user_model->get_specific_user($userid);
      $data = array(
      'page_heading' => 'Dashboard',
      'user' => $this->user_model->get_specific_user($userid),
      'totaldishes' => $this->dish_model->get_total_dishes(),
      'totalrestaurants' => $this->restaurant_model->get_total_restaurants(),
      'totalusers' => $this->user_model->get_total_users(),
			'totalcomments' => $this->comment_model->get_total_comments(),
			'currentPage' => 'admin_profile'
      );
      $this->load->view('templates/header',$data);
      $this->load->view('admin_profile',$data);
      $this->load->view('templates/footer',$data);
			
   }
   else {
     redirect('index.php/login');
   }
  }
	
	
	public function users() {
    if(isset($_SESSION['logged_in_user_id'])) {
			
      $userid = $this->session->userdata('logged_in_user_id');
      $user = $this->user_model->get_specific_user($userid);
      $data = array(
      'page_heading' => 'Users',
      'user' => $this->user_model->get_specific_user($userid),
      'allusers' => $this->user_model->get_all_users(),
			'users_per_group' => $this->user_model->get_users_per_group(),
			'currentPage' => 'users'
      );
      $this->load->view('templates/header',$data);
      $this->load->view('users',$data);
      $this->load->view('templates/footer',$data);
			
   }
   else {
     redirect('index.php/login');
   }
  }


}
