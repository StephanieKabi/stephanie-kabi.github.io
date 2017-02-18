<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Explore extends CI_Controller {


   function __construct()  {

     parent::__construct();

   }


   function index() {
		 
     $page = 'explore';
     if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
       show_404(); // Whoops, we don't have a page for that!
     }
     else {
       $data = array(
         'page_heading' => 'Explore',
				 'explore_dishes' => $this->dish_model->get_explore_dishes(),
				 'currentPage' => 'explore'
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
	
	
	function search() {

		$this->session->unset_tempdata('searchTermResults');
		
		$searchTerm = $this->input->post('exploreSearchInput');
		$searchTermResults = $this->dish_model->get_explore_search($searchTerm);
		
		if(null !== $searchTermResults) {
			$this->session->set_flashdata('searchTerm', $searchTerm, 300);
			$this->session->set_tempdata('searchTermResults', $searchTermResults, 300);
		}
		else {
			$this->session->set_flashdata('searchTerm', $searchTerm, 300);
			$searchTermErrMsg = "Sorry, there are no results for '".$searchTerm."'.";
			$this->session->set_flashdata('searchTermErr',$searchTermErrMsg);
		}
		
		$page = 'explore_search';
     if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
       show_404(); // Whoops, we don't have a page for that!
     }
     else {
       $data = array(
         'page_heading' => "Results for $searchTerm",
				 'currentPage' => 'explore'
       );
			 
			$searchTermFlash = $this->session->tempdata('searchTerm');
			$searchTermResultsFlash = $this->session->tempdata('searchTermResults');
			if(isset($searchTermResultsFlash)) {
				$data['searchTermFlash'] = $searchTermFlash;
				$data['searchTermResultsFlash'] = $searchTermResultsFlash;
			}
			 
			 
       if(isset($_SESSION['logged_in_user_id'])) {
         $userid = $this->session->userdata('logged_in_user_id');
         $data['user'] = $this->user_model->get_specific_user($userid);
       }
       $this->load->view('templates/header',$data);
       $this->load->view($page,$data);
       $this->load->view('templates/footer',$data);
     }
		
		
		
	}
	
	
	function item() {
		
     $page = 'explore_item';
     if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
       show_404(); // Whoops, we don't have a page for that!
     }
     else {
			 $dishlistingid = $_GET['did'];
       $data = array(
         'page_heading' => 'Explore',
				 'explore_item_img' => $this->dish_model->get_specific_explore_item_img($dishlistingid),
				 'explore_item_pt1' => $this->dish_model->get_specific_explore_item_pt1($dishlistingid),
				 'explore_item_pt2' => $this->dish_model->get_specific_explore_item_pt2($dishlistingid),
				 'explore_item_similars' => $this->dish_model->get_explore_item_similars($dishlistingid),
				 'currentPage' => 'explore'
       );
       $this->load->view('templates/header',$data);
       $this->load->view($page,$data);
       $this->load->view('templates/footer',$data);
     }
	
	}
	
	
	public function restaurant() {
		
		$page = 'restaurant_item';
     if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
       show_404(); // Whoops, we don't have a page for that!
     }
     else {
			 
			 $restaurantid = $_GET['rid'];
			 $restaurant = $this->restaurant_model->get_restaurant_explore($restaurantid);
			 

			 $placeDetailsKey = 'AIzaSyCpQalihjXSqV31oMIhgjTUAEFqPViQ3rc';
			 $placeId = $restaurant->placeid;
			 $urlPlaceDetails = 'https://maps.googleapis.com/maps/api/place/details/json?key='.$placeDetailsKey.'&placeid='.$placeId;
			 $json_response = file_get_contents($urlPlaceDetails);
			 $place_details_response = json_decode($json_response,true);
			 
			 $opinion_stats_php = $this->dish_model->get_sentiment_stats($restaurant);
			 $opinion_stats_json = json_encode($opinion_stats_php);
			 $opinion_stats = '{"stats":['.$opinion_stats_json.']}';
			 
       $data = array(
         'page_heading' => $restaurant->restaurantname,
				 'restaurant' => $restaurant,
				 'place_details' => $place_details_response,
				 'menuItems' => $this->dish_model->get_menu_dishes($restaurantid),
				 'popularity_short' => $this->dish_model->get_popularity_short($restaurant),
				 'comments_short' => $this->dish_model->get_comments_short($restaurant),
				 'opinion_stats' => $opinion_stats,
				 'reviews' => $this->review_model->get_reviews($restaurantid),
				 'currentPage' => 'explore'
       );
       $this->load->view('templates/header',$data);
       $this->load->view($page,$data);
       $this->load->view('templates/footer',$data);
     }
		
	}




}
