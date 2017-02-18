<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {


 function __construct()  {

   parent::__construct();

   function generate_random_salt($input,$cost) {
     $salt = ""; //declare the $salt variable
     $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9)); //generate the 22 random alphanumerics
     for ($i=0; $i < 22; $i++) {
       $salt .= $salt_chars[array_rand($salt_chars)]; //concatenates a random character from $salt_chars to $salt
     }
     return crypt($input, sprintf('$2a$%02d$',$cost).$salt);
   }

 }


 function index() {

		$page = 'signup';
		if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
		 show_404(); // Whoops, we don't have a page for that!
		}
		else {
		 $data = array(
			 'page_heading' => 'Sign Up',
			 'panel_title_1' => 'Create Your Account.',
			 'currentPage' => 'login'
		 );
		 $this->load->view('templates/header',$data);
		 $this->load->view($page,$data);
		 $this->load->view('templates/footer',$data);
		}

 }
	
	
	public function send_confirmation( $emailaddress,$firstName,$hash ) {
		
		require 'class.smtp.php';
		require 'class.phpmailer.php';
		
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Mailer = 'smtp';
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.gmail.com'; // "ssl://smtp.gmail.com" didn't worked
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->Username = "hello.delischi@gmail.com";
		$mail->Password = "Hell0delischi";

//		$mail->IsHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

		$mail->From = "hello.delischi@gmail.com";
		$mail->FromName = "Delischi";

		$mail->addAddress($emailaddress);
//	$mail->addAddress("user.2@gmail.com","User 2");
//	$mail->addCC("user.3@ymail.com","User 3");
//	$mail->addBCC("user.4@in.com","User 4");

		$mail->Subject = "Welcome to Delischi!";
		$mail->Body = /*-----------email body starts-----------*/
			'Thanks for signing up, '.$firstName.'!
			
			Your account has been created. Please click this link to verify yoyr email:
            
      '.base_url().'index.php/signup/verify?email='.$emailaddress.'&hash='.$hash;
		/*-----------email body ends-----------*/		      
		
		$mail->Send();

	}
	
	
	function verify() {
		$emailaddress = $_GET['email'];
		$hash = $_GET['hash'];
		$result = $this->user_model->get_hash_value($hash); //get the hash value which belongs to given email from database
		if( null !== $result ){ 
			foreach($result as $row) {
				$dbhash = $row->hash;
			}
			if( $dbhash == $hash ){  //check whether the input hash value matches the hash value retrieved from the database
				$this->user_model->verify_user($emailaddress); //update the status of the user as verified
				/*---Now you can redirect the user to whatever page you want---*/
				$this->session->set_tempdata('emailAddressConfirmation', '<div class="alert alert-success">Your email has been verified.</div>');
				redirect('index.php/login','refresh');
			}
		}
	}


  public function create_user() {

    $this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
    $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
    $this->form_validation->set_rules('inputEmail', 'Email', 'trim|required|valid_email|is_unique[login_credentials.emailaddress]');
    $this->form_validation->set_rules('inputPassword', 'Password', 'trim|required');
    $this->form_validation->set_rules('confirmPassword', 'Confirm Password','trim|required');

    if($this->form_validation->run() == FALSE) {
      $page = 'signup';
      if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
        show_404(); // Whoops, we don't have a page for that!
      }
      else {
        $data = array(
          'page_heading' => 'Sign Up',
					'panel_title_1' => 'Create An Account',
			 		'currentPage' => 'login'
        );
        $this->load->view('templates/header',$data);
        $this->load->view($page,$data);
        $this->load->view('templates/footer',$data);
      }
    }
    else {
			// check whether passwords match
			$firstPass =  $this->input->post('inputPassword');
			$confirmPass = $this->input->post('confirmPassword');
			if( $firstPass !== $confirmPass ) {
				$this->session->set_flashdata('passMatchErr', '<div class="alert alert-danger">Oops! Passwords don\'t match.</div>');
				redirect('index.php/signup/create_user');
			}
			else {
				
				$firstName = $this->input->post('firstName');
				$lastName = $this->input->post('lastName');
				$user = array (
					'firstname' => $firstName,
					'lastname' => $lastName,
					'username' => $firstName."".$lastName."".microtime(),
					'usertypeid' => $this->input->post('accountType')
				);
				/*
				if (isset($_FILES['image'])) {
					$upload_directory = base_url()."uploadedImages/profile";
					$tmp_name = $_FILES[ 'image' ][ 'tmp_name' ];
					$file_name = $_FILES[ 'image' ][ 'name' ];
					move_uploaded_file($tmp_name, "$upload_directory/$file_name");
					$user['imagepath'] = $file_name;
				}
				*/
				if (isset($_FILES['image'])) {
					$uploaded_file_name = $_FILES[ 'image' ][ 'name' ];
					//$file_path = base_url()."uploadedImages/profile/".$uploaded_file_name;
					$file_path = "C:/wamp64/www/Delischi/uploadedImages/profile/".$uploaded_file_name;
					move_uploaded_file( $_FILES['image']['tmp_name'], $file_path );
				}
				$emailaddress = strtolower($this->input->post('inputEmail'));
				$encpassword = generate_random_salt($confirmPass,10);
				$hash = md5(rand(0,1000));
				$userid = $this->user_model->add_user($user,$emailaddress);
				$login_credentials = array (
					'emailaddress' => $emailaddress,
					'encpassword' => $encpassword,
					'hash' => $hash,
					'userid' => $userid
				);
				if ( ! $this->user_model->add_login_credentials($login_credentials) ) {
					echo "User not added."."<br>";
				}
				else {
										
					$usertypeid = $this->input->post('accountType');
					
					if ($usertypeid!=='2') { // if user is admin or customer
						
						$this->session->set_tempdata('emailAddressConfirmation', '<div class="alert alert-info">Your account has been created. Please check your email inbox for an activation email.</div>');
						$this->send_confirmation( $emailaddress,$firstName,$hash );
						redirect('index.php/login','refresh');
						
					}
					else {
						$vicinity = $this->input->post('newPlaceVicinitySignup');
						if(isset($vicinity)) {
							$restaurant = array (
								'userid' => $userid,
								'restaurantname' => $this->input->post('restaurantNameSignup'),
								'vicinity' => '',
								'placeid' => '',
								'longitude' => '',
								'latitude' => ''
							);
							$this->session->set_tempdata('updateRestaurantInfoWarning', 'Please add '.$restaurant['restaurantname'].' on Google Maps.', 300);
						}
						else {
							$restaurant = array (
								'userid' => $userid,
								'restaurantname' => $this->input->post('newPlaceNameSignup'),
								'vicinity' => $this->input->post('newPlaceVicinitySignup'),
								'placeid' => $this->input->post('newPlaceIDSignup'),
								'longitude' => $this->input->post('newPlaceLngSignup'),
								'latitude' => $this->input->post('newPlaceLatSignup')
							);
						}
						$confirmUpdate = $this->restaurant_model->update_restaurant($restaurant);
						if($confirmUpdate !== null ){
							$this->user_model->delete_user($userid);
							$this->session->set_flashdata('restClaimErr', '<div class="alert alert-danger">'.$confirmUpdate.'</div>');
							redirect('index.php/signup/create_user');
						}
						else {
							
							$this->session->set_tempdata('emailAddressConfirmation', '<div class="alert alert-info">Your account has been created. Please check your email inbox for an activation email.</div>');
							$this->send_confirmation( $emailaddress,$firstName,$hash );
							redirect('index.php/login','refresh');
							
						}
						
					} // if user is business owner
					
				}
				
			}

    } 

  }


}

?>
