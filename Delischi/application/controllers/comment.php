<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {


  function __construct()  {

    parent::__construct();

    $this->load->library('Curl');

    include APPPATH.'third_party/Unirest/Request/Body.php';
    include APPPATH.'third_party/Unirest/Exception.php';
    include APPPATH.'third_party/Unirest/Method.php';
    include APPPATH.'third_party/Unirest/Request.php';
    include APPPATH.'third_party/Unirest/Response.php';

  }


  public function index() {
    if(isset($_SESSION['logged_in_user_id'])) {

      $userid = $this->session->userdata('logged_in_user_id');
       $page = 'new_comment';
       if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
           show_404(); // Whoops, we don't have a page for that!
       }
       else {
         $data = array(
           'page_heading' => 'New Comment',
           'panel_title_1' => 'New Comment',
           'user' => $this->user_model->get_specific_user($userid),
					 'currentPage' => 'account'
         );
         $this->load->view('templates/header',$data);
         $this->load->view($page,$data);
         $this->load->view('templates/footer',$data);
       }
     }
     else {
       redirect('index.php/login');
     }
  }
	
	
	public function delete_comment() {
		if (isset($_GET['cid'])){
			$commentid = $_GET['cid'];
      $this->comment_model->delete_comment($commentid);
			redirect('index.php/user/profilec');
    }
	}


  public function new_comment() {

    // 1. Get dish  ID
    $dishname = $this->input->post('dishName');
    $dish_id = $this->dish_model->get_dish_id($dishname);
    // 2. Get restaurant ID
    $restaurant = array (
      'restaurantname' => $this->input->post('newPlaceName'),
      'vicinity' => $this->input->post('newPlaceVicinity'),
      'placeid' => $this->input->post('newPlaceID'),
      'longitude' => $this->input->post('newPlaceLng'),
      'latitude' => $this->input->post('newPlaceLat')
    );
    $restaurant_id = $this->restaurant_model->get_restaurant_id($restaurant);
    // 3. Get date
    $visit_date = date('Y-m-d', strtotime($this->input->post('visitDate')));
    // 4. Get comment
    $comment_body = $this->input->post('dishComment');
    // 5. Copy the image to 'images' directory in server
    if (isset($_FILES['image'])) {
      $uploaded_file_name = $_FILES[ 'image' ][ 'name' ];
      //$file_path = base_url()."uploadedImages/dish/".$uploaded_file_name;
      $file_path = "C:/wamp64/www/Delischi/uploadedImages/dish/".$uploaded_file_name;
      move_uploaded_file( $_FILES['image']['tmp_name'], $file_path );
    }
    // 6. Insert new dish listing
    $dish_listing = array (
      'dishid' => $dish_id,
      'restaurantid' => $restaurant_id
    );
    $dish_listing_id = $this->dish_model->get_dish_listing_id($dish_listing);

    // 7. Get comment sentiment
    $response = Unirest\Request::post("https://twinword-sentiment-analysis.p.mashape.com/analyze/",
      array(
        "X-Mashape-Key" => "b7f4cpOSqtmshiOdEIFBDuMfmyXGp1xBByGjsnQq5d8EPCiTJa",
        // "Content-Type" => "application/x-www-form-urlencoded", // do not uncomment this line, else the request will not work and will return an 'invalid request' message
        "Accept" => "application/json"
      ),
      array(
        "text" => $comment_body
      )
    );
    $response = get_object_vars($response); // store response object properties into an array
    $response_body = $response['raw_body']; // get the response body array
    $response_body = json_decode($response_body,true); // decode the raw boyd from json to a php array
    $comment_sentiment = $response_body['type'];
    $comment_score = $response_body['score'];

    // 8. Insert comment
    $comment = array (
      'userid' => $this->session->userdata('logged_in_user_id'),
      'dishlistingid' => $dish_listing_id,
      'sentimenttype' => $comment_sentiment,
      'imagename' => $uploaded_file_name,
      'title' => $this->input->post('dishName'),
      'datevisit' => $visit_date,
      'body' => $comment_body
    );
    $this->comment_model->add_comment($comment);
    $this->dish_model->update_sentiment_numbers($dish_listing_id);
    redirect('index.php/user/profilec');

  }


  public function update_comment() {

    if(isset($_SESSION['logged_in_user_id'])) {

      $userid = $this->session->userdata('logged_in_user_id');
      $commentid = $this->session->userdata('edit_comment_id');

      if(isset($_GET['cid'])) {
        $session_data = array(
          'edit_comment_id' => $_GET['cid']
        );
        $this->session->set_userdata($session_data);
        $commentid = $this->session->userdata('edit_comment_id');
      }

      $page = 'new_comment';
      if ( ! file_exists(APPPATH.'views/'.$page.'.php')) {
          show_404(); // Whoops, we don't have a page for that!
      }
      else {
        $data = array(
          'page_heading' => 'Update Comment',
          'panel_title_1' => 'Update Your Comment',
          'user' => $this->user_model->get_specific_user($userid),
          'comment' => $this->comment_model->get_specific_comment($commentid),
					'currentPage' => ''
        );
        $this->load->view('templates/header',$data);
        $this->load->view($page,$data);
        $this->load->view('templates/footer',$data);
      }

      if (isset($_POST['submit_comment_update'])) {

        $commentid = $this->input->post('commentid_txt');

        // 1. Get dish  ID
        $dishname = $this->input->post('dishName');
        $dish_id = $this->dish_model->get_dish_id($dishname);
        // 2. Get restaurant ID
        $restaurant = array (
					'restaurantname' => $this->input->post('newPlaceName'),
					'vicinity' => $this->input->post('newPlaceVicinity'),
					'placeid' => $this->input->post('newPlaceID'),
					'longitude' => $this->input->post('newPlaceLng'),
					'latitude' => $this->input->post('newPlaceLat'),
					'placeid' => $this->input->post('newPlaceID')
				);
        $restaurant_id = $this->restaurant_model->get_restaurant_id($restaurant);
        // 3. Get date
        $visit_date = date('Y-m-d', strtotime($this->input->post('visitDate')));
        // 4. Get comment
        $comment_body = $this->input->post('dishComment');
        // 5. Insert new dish listing
        $dish_listing = array (
          'dishid' => $dish_id,
          'restaurantid' => $restaurant_id
        );
        $dish_listing_id = $this->dish_model->get_dish_listing_id($dish_listing);

        // 6. Get comment sentiment
        $response = Unirest\Request::post("https://twinword-sentiment-analysis.p.mashape.com/analyze/",
          array(
            "X-Mashape-Key" => "b7f4cpOSqtmshiOdEIFBDuMfmyXGp1xBByGjsnQq5d8EPCiTJa",
            // "Content-Type" => "application/x-www-form-urlencoded", // do not uncomment this line, else the request will not work and will return an 'invalid request' message
            "Accept" => "application/json"
          ),
          array(
            "text" => $comment_body
          )
        );
        $response = get_object_vars($response); // store response object properties into an array
        $response_body = $response['raw_body']; // get the response body array
        $response_body = json_decode($response_body,true); // decode the raw boyd from json to a php array
        $comment_sentiment = $response_body['type'];
        $comment_score = $response_body['score'];
        // 7. Update comment
        $comment = array (
          'commentid' => $commentid,
          'dishlistingid' => $dish_listing_id,
          'sentimenttype' => $comment_sentiment,
          'title' => $this->input->post('dishName'),
          'datevisit' => $visit_date,
          'body' => $comment_body
        );
        // 8. Copy the image to 'images' directory in server
        if (isset($_FILES['image'])) {
					$uploaded_file_name = $_FILES[ 'image' ][ 'name' ];
					$file_path = "C:/wamp64/www/Delischi/uploadedImages/dish/".$uploaded_file_name;
					move_uploaded_file( $_FILES['image']['tmp_name'], $file_path );
				}
        $this->comment_model->update_comment($comment);
        $this->dish_model->update_sentiment_numbers($dish_listing_id);
        redirect('index.php/user/profilec');

      }

    }
    else {
      redirect('index.php/login');
    }


  }


}
