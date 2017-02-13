<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {


 function __construct()  {

   parent::__construct();

 }


 function index() {
	 
   $page = 'about';
   if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
     show_404(); // Whoops, we don't have a page for that!
   }
   else {
     $data = array(
       'page_heading' => 'About',
       'panel_title_1' => 'About',
			 'currentPage' => 'about'
     );
     if(isset($_SESSION['logged_in_user_id'])) {
       $userid = $this->session->userdata('logged_in_user_id');
       $data['user'] = $this->user_model->get_specific_user($userid);
     }
     $this->load->view('templates/header',$data);
     $this->load->view($page,$data);
     $this->load->view('templates/footer',$data);
   }

 }

 }
