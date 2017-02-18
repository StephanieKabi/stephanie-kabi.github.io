<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_model extends CI_Model {


  public function __construct() {

    parent::__construct();

  }
	
	
	public function get_total_restaurants() {
		$query = $this->db->query("select count(*) as totalrestaurants from restaurant");
		if($query->num_rows()>0) {
      return $query->result();
    }
	}
	
	
	public function get_restaurant_explore($restaurantid) {
    $this->db->from('restaurant');
    $this->db->where('restaurantid', $restaurantid);
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) { // If record exists
      foreach ($query->result() as $row) {
        return $row;
      }
    }
    else { // If record does not exist
      return NULL;
    }
  }


  public function get_restaurant($userid) {
    $this->db->from('restaurant');
    $this->db->where('userid', $userid);
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) { // If record exists
      foreach ($query->result() as $row) {
        return $row;
      }
    }
    else { // If record does not exist
      return NULL;
    }
  }
	

  public function get_restaurant_id($restaurant) { // create restaurant and return restaurant id
    $this->db->from('restaurant');
    $this->db->where('placeid', $restaurant['placeid']);
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) { 
      foreach ($query->result() as $row) {
        return $row->restaurantid;
      }
    }
    else { 
      $this->db->insert('restaurant', $restaurant); 
      return $this->db->insert_id();
    }
  }


  public function update_restaurant($restaurant) {
		$restaurantid = $this->get_restaurant_id($restaurant);
		$this->db->from('restaurant');
    $this->db->where('placeid', $restaurant['placeid']);
		$this->db->select('userid');
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) { // if the existing restaurant has an owner
			foreach ($query->result() as $row) {
        $db_userid = $row->userid;
      }
			if($db_userid!==$restaurant['userid']) { // if restaurant is already owned by someone else
				return "Oops! ".$restaurant['restaurantname']." has already been claimed.";
			}
			else { // if I own the existing restaurant
				$this->db->set('restaurantname', $restaurant['restaurantname']);
				$this->db->set('vicinity', $restaurant['vicinity']);
				$this->db->set('longitude', $restaurant['longitude']);
				$this->db->set('latitude', $restaurant['latitude']);
				$this->db->set('placeid', $restaurant['placeid']);
				$this->db->where('userid', $restaurant['userid']);
			}
    }
    else { // If existing restaurant is not claimed yet
			// remove the user id from all restaurants using this user id
			$this->db->where('userid', $restaurant['userid']);
			$this->db->set('userid', '');
			$this->db->update('restaurant');
			// remove the user id from all restaurants using this user id
			$this->db->where('restaurantname', $restaurant['restaurantname']);
			$this->db->where('vicinity', $restaurant['vicinity']);
			$this->db->set('userid', $restaurant['userid']);
			$this->db->update('restaurant');
    }
  }


  public function get_number_restaurants_visited($userid) {
    $this->db->from('restaurant');
    $this->db->join('dish_listing', 'restaurant.restaurantid=dish_listing.restaurantid');
    $this->db->join('comment', 'dish_listing.dishlistingid=comment.dishlistingid');
    $this->db->join('user', 'user.userid=comment.userid');
    $this->db->where('user.userid', $userid);
    $this->db->select('restaurant.restaurantid');
    $this->db->distinct();
    return $this->db->count_all_results();
  }


}

?>
