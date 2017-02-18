<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct()  {
		
		parent::__construct();
	
	}
	
	
	function index() {

   	$page = 'home';
   	if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
			show_404(); // Whoops, we don't have a page for that!
		}
		else {

			$data = array(
				'page_heading' => 'Home',
			 	'currentPage' => 'home'
     	);
			
			$homeResultsFlash = $this->session->tempdata('homeResults');
			$homeDishTypes = $this->session->tempdata('homeDishTypes');
			$homePlace = $this->session->tempdata('homePlace');
			if(isset($homeResultsFlash)) {
				$data['homeResultsFlash'] = $homeResultsFlash;
				$data['homeDishTypes'] = $homeDishTypes;
				$data['homePlace'] = $homePlace;
			}
			
     	if(isset($_SESSION['logged_in_user_id'])) {
			 
				$userid = $this->session->userdata('logged_in_user_id');
       	$usertype = $this->session->userdata('usertype');
       	$imagename = $this->session->userdata('profile_image');
       	$data['user'] = $this->user_model->get_specific_user($userid);
			 
				if ($usertype=="Administrator") {
				 	redirect('index.php/admin/dashboard');
				}
			 	elseif ($usertype=="Restaurant Owner") {
					redirect('index.php/restaurant/dashboard');
				}
			 	else {
					$this->load->view('templates/header',$data);
					$this->load->view($page,$data);
					$this->load->view('templates/footer',$data);
				}
     	}
		 	else {
				$this->load->view('templates/header',$data);
				$this->load->view($page,$data);
				$this->load->view('templates/footer',$data);
			}
			
			if (isset($_POST['homeSubmit'])) {
			
				if(null !== $this->session->tempdata('homeResults')) {
					$this->session->unset_tempdata('homeResults');
				}
				
				$homePlace = $this->input->post('homePlace');
				$homeResults = $this->dish_model->get_home_dishes($homePlace);
				$homeDishTypes = $this->dishtype_model->get_all_dishtypes();
				
				if(null !== $homeResults) {
					$this->session->set_tempdata('homeResults', $homeResults, 300);
					$this->session->set_tempdata('homeDishTypes', $homeDishTypes, 300);
					$this->session->set_tempdata('homePlace', $homePlace, 300);
				}
				else {
					$homeResultsErrMsg = "Sorry, there are no dish recommendations in ".$homePlace.". <br> But you can try another cuisine or place instead!";
					$this->session->set_flashdata('homeResultsErr',$homeResultsErrMsg);
				}
				redirect('');
			
			}
		
		}
	
	}


}
