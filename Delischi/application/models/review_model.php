<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model {


  public function __construct() {

    parent::__construct();

  }
	
	
	public function get_reviews($restaurantid) {
		$this->db->from('user');
    $this->db->join('comment', 'user.userid = comment.userid');
    $this->db->join('dish_listing', 'comment.dishlistingid = dish_listing.dishlistingid');
    $this->db->join('restaurant', 'restaurant.restaurantid = dish_listing.restaurantid');
		$this->db->where('restaurant.restaurantid', $restaurantid);
    $this->db->join('dish', 'dish.dishid = dish_listing.dishid');
		$this->db->select('dish.dishname, user.imagepath, user.firstname, user.lastname, min(comment.imagename) as imagename, comment.sentimenttype, COMMENT.body, comment.datevisit ');
    $this->db->group_by('dish.dishname, user.userid, comment.commentid');
		$this->db->order_by('dish.dishname', 'ASC');
		$this->db->order_by('comment.datevisit', 'DESC');
    $query = $this->db->get();
    if($query->num_rows()>0) {
      return $query->result();
    }
	}

}

?>
