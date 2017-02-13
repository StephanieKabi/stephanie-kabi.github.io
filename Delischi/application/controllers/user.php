<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


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


  public function update_profile() {

    if(isset($_SESSION['logged_in_user_id'])) {
			
      $userid = $this->session->userdata('logged_in_user_id');
			$user = $this->user_model->get_specific_user($userid);
      $restaurant = $this->restaurant_model->get_restaurant($userid);
      $data = array(
        'page_heading' => $user->firstname." ".$user->lastname,
        'panel_title_1' => 'Update Your Profile',
        'user' => $user,
        'restaurant' => $restaurant,
				'currentPage' => 'account'
      );
      $this->load->view('templates/header',$data);
      $this->load->view('update_profile',$data);
      $this->load->view('templates/footer',$data);

      if (isset($_POST['submit_user_update'])) {
				
				// check whether passwords match
				$firstPass =  $this->input->post('inputPasswordUpdate');
        $confirmPass = $this->input->post('confirmPasswordUpdate');
				if( $firstPass !== $confirmPass ) {
					$this->session->set_flashdata('passMatchErr', '<div class="alert alert-danger">Oops! Passwords don\'t match.</div>');
					redirect('index.php/user/update_profile');
				}
				else {
					
					// Copy the image to 'images' directory in server
					$user = array (
						'firstname' => $this->input->post('firstNameUpdate'),
						'lastname' => $this->input->post('lastNameUpdate'),
						'username' => $this->input->post('firstNameUpdate')."".$this->input->post('firstNameUpdate')."".microtime(),
						'userid' => $this->session->userdata('logged_in_user_id'),
					);
					if (isset($_FILES['image'])) {
						$upload_directory = "C:/wamp64/www/Delischi/uploadedImages/profile";
						$tmp_name = $_FILES[ 'image' ][ 'tmp_name' ];
						$file_name = $_FILES[ 'image' ][ 'name' ];
						move_uploaded_file($tmp_name, "$upload_directory/$file_name");
						$user['imagepath'] = $file_name;
					}
					$login_credentials = array (
						'encpassword' => generate_random_salt($confirmPass,10),
						'userid' => $this->session->userdata('logged_in_user_id')
					);
					$this->user_model->update_user($user,$login_credentials);
							
					if ($this->session->userdata('usertype')=='Administrator') { 
						redirect('index.php/user/profilea');
					}
					else if ($this->session->userdata('usertype')=='Food Writer') { 
						redirect('index.php/user/profilec');
					}
					else {
						$restaurant = array (
							'userid' => $this->session->userdata('logged_in_user_id'),
							'restaurantname' => $this->input->post('newPlaceNameUpdate'),
							'vicinity' => $this->input->post('newPlaceVicinityUpdate'),
							'placeid' => $this->input->post('newPlaceIDUpdate'),
							'longitude' => $this->input->post('newPlaceLngUpdate'),
							'latitude' => $this->input->post('newPlaceLatUpdate')
						);
						$confirmUpdate = $this->restaurant_model->update_restaurant($restaurant);
						if($confirmUpdate !== null ){
							$this->session->set_flashdata('restClaimErr', '<div class="alert alert-danger">'.$confirmUpdate.'</div>');
							redirect('index.php/user/update_profile');
						}
						else {
							redirect('index.php/restaurant/info');
						}
					}
					
				}

      }

    }
    else {
      redirect('index.php/login','refresh');
    }

  }


  public function profilec() {
    if(isset($_SESSION['logged_in_user_id'])) {
      $userid = $this->session->userdata('logged_in_user_id');
			$user = $this->user_model->get_specific_user($userid);
      $data = array(
        'page_heading' => $user->firstname.' '.$user->lastname,
        'panel_title_1' => 'Dishes You Have Reviewed',
        'user' => $user,
        'number_dishes_eaten' => $this->dish_model->get_number_dishes_eaten($userid),
        'number_places_visited' => $this->restaurant_model->get_number_restaurants_visited($userid),
        'number_cuisines_eaten' => $this->dishtype_model->get_cuisines_eaten($userid),
        'personal_comments' => $this->comment_model->get_all_comments($userid),
				'currentPage' => 'account'
      );
      $this->load->view('templates/header',$data);
      $this->load->view('templates/profile_card',$data);
      $this->load->view('customer_profile',$data);
      $this->load->view('templates/footer',$data);
    }
    else {
     redirect('index.php/login');
    }
  }


  public function profilea() {
    if(isset($_SESSION['logged_in_user_id'])) {
      $userid = $this->session->userdata('logged_in_user_id');
      $user = $this->user_model->get_specific_user($userid);
      $data = array(
      'page_heading' => 'Administrator',
      'user' => $this->user_model->get_specific_user($userid),
      'allusers' => $this->user_model->get_all_users(),
			'users_per_group' => $this->user_model->get_users_per_group(),
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


  public function logout() {
    $this->session->sess_destroy();
    redirect('','refresh'); //will redirect to default route, which is the "Home" controller
  }


}
