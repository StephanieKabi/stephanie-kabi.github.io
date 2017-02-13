<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant extends CI_Controller {


 	function __construct()  {

   	parent::__construct();

 	}


 	function index() {}
	

  public function dashboard() {
    if(isset($_SESSION['logged_in_user_id'])) {
      $userid = $this->session->userdata('logged_in_user_id');
      $restaurant = $this->restaurant_model->get_restaurant($userid);
			
      $opinion_stats_php = $this->dish_model->get_sentiment_stats($restaurant);
      $opinion_stats_json = json_encode($opinion_stats_php);
      $opinion_stats = '{"stats":['.$opinion_stats_json.']}';
			
			$menu_items_stats_php = $this->dish_model->get_menu_items_stats($restaurant);
			$menu_items_stats_json = json_encode($menu_items_stats_php);
			$menu_items_stats = '{"stats":['.$menu_items_stats_json.']}';
		
			
			

      $data = array(
        'page_heading' => 'Dashboard',
        'user' => $this->user_model->get_specific_user($userid),
        'restaurant' => $restaurant,
        'mentions' => $this->dish_model->get_number_dishes_mentioned($restaurant),
        'comments_number' => $this->comment_model->get_number_comments($restaurant),
        'opinion_stats' => $opinion_stats,
				'popularity_short' => $this->dish_model->get_popularity_short($restaurant),
				'comments_short' => $this->dish_model->get_comments_short($restaurant),
				'menu_items_stats_php' => $menu_items_stats_php,
				'currentPage' => 'business_dashboard'
      );
      $this->load->view('templates/header',$data);
      $this->load->view('business/dashboard',$data);
      $this->load->view('templates/footer',$data);
    }
    else {
      redirect('index.php/login');
    }
  }
	
	
	function get_dishtypes_c(){
    if (isset($_GET['term'])){
			$searchTerm = $_GET['term'];
      $ans = $this->dishtype_model->get_autocomplete_dish_type($searchTerm);
			echo $ans;
    }
  }


  public function menu() {
    if(isset($_SESSION['logged_in_user_id'])) {
      $userid = $this->session->userdata('logged_in_user_id');
      $restaurant = $this->restaurant_model->get_restaurant($userid);
      $restaurant_id = $restaurant->restaurantid;
			
      $data = array(
        'user' => $this->user_model->get_specific_user($userid),
        'restaurant' => $restaurant,
        'menuItems' => $this->dish_model->get_menu_dishes($restaurant_id),
				'currentPage' => 'menu'
      );
			
      $restaurant_name = $restaurant->restaurantname;
			$lastChar = substr($restaurant_name,-1);
			if($lastChar == "s") {
				$data['page_heading'] = $restaurant_name."' Menu";
			}
			else {
				$data['page_heading'] = $restaurant_name."'s Menu";
			}
			
      $this->load->view('templates/header',$data);
      $this->load->view('business/menu',$data);
      $this->load->view('templates/footer',$data);

      if (isset($_POST['submit_menu'])) {
				
				$dishname = $this->input->post('dishNameMenu');
				$dish_id = $this->dish_model->get_dish_id($dishname);
				
				$dishtype = $this->input->post('dishTypeMenuField');
        $dishtype_id = $this->dishtype_model->get_dish_type_id($dishtype);

        $userid = $this->session->userdata('logged_in_user_id');
				
        $restaurant = $this->restaurant_model->get_restaurant($userid);
        $restaurant_id = $restaurant->restaurantid;
				
        $dish_listing = array(
          'dishid' => $dish_id,
          'restaurantid' => $restaurant_id,
          'dishtypeid' => $dishtype_id,
          'dishdescription' => $this->input->post('dishDescMenu')
        );
        if(!$this->dish_model->get_dish_listing_id($dish_listing)) {
          echo "Item not added"."<br><br>";
          echo "Dish name = ".$dishname."<br>";
          echo "Dish type = ".$dishtype."<br>";
          echo "Dish type id = ".$dishtype_id."<br>";
          echo "Dish id = ".$dish_id."<br>";
          echo "Dish description = ".$dish_listing['dishdescription']."<br>";
          echo "User id = ".$userid."<br>";
          echo "Restaurant id = ".$restaurant_id."<br>";
        }
        else {
          redirect('index.php/restaurant/menu');
        }

      }

    }
    else {
      redirect('index.php/login');
    }
  }
	
	
	public function delete_menu_item() {
		if (isset($_GET['dlid'])){
			$dishlistingid = $_GET['dlid'];
      $this->dish_model->delete_menu_item($dishlistingid);
			redirect('index.php/restaurant/menu');
    }
	}


  public function info() {
    if(isset($_SESSION['logged_in_user_id'])) {
      $userid = $this->session->userdata('logged_in_user_id');
			$restaurant = $this->restaurant_model->get_restaurant($userid);
			
			$placeDetailsKey = 'AIzaSyCpQalihjXSqV31oMIhgjTUAEFqPViQ3rc';
			$placeId = $restaurant->placeid;
			$urlPlaceDetails = 'https://maps.googleapis.com/maps/api/place/details/json?key='.$placeDetailsKey.'&placeid='.$placeId;
			$json_response = file_get_contents($urlPlaceDetails);
			$place_details_response = json_decode($json_response,true);
			
			$data = array(
        'page_heading' => 'Info',
        'user' => $this->user_model->get_specific_user($userid),
        'restaurant' => $restaurant,
				'json_response' => $json_response,
				'place_details' => $place_details_response,
				'currentPage' => 'info'
      );
      $this->load->view('templates/header',$data);
      $this->load->view('templates/profile_card',$data);
      $this->load->view('business/restaurant_info',$data);
      $this->load->view('templates/footer',$data);
    }
    else {
      redirect('index.php/login');
    }
  }
	
	
	  public function reviews() {
    if(isset($_SESSION['logged_in_user_id'])) {
      $userid = $this->session->userdata('logged_in_user_id');
      $restaurant = $this->restaurant_model->get_restaurant($userid);
			$restaurantid = $restaurant->restaurantid;
      $data = array(
        'page_heading' => 'Reviews',
        'panel_title_1' => 'Reviews About Your Dishes',
        'user' => $this->user_model->get_specific_user($userid),
        'restaurant' => $restaurant,
				'reviews' => $this->review_model->get_reviews($restaurantid),
				'currentPage' => 'business_reviews'
      );
      $this->load->view('templates/header',$data);
      $this->load->view('business/biz_customer_reviews',$data);
      $this->load->view('templates/footer',$data);
    }
    else {
      redirect('index.php/login');
    }
  }
	
	
}