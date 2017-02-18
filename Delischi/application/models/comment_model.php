<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {


  public function __construct() {

    parent::__construct();

  }
	
	
	public function get_total_comments() {
		$query = $this->db->query("select count(*) as totalcomments from comment");
		if($query->num_rows()>0) {
      return $query->result();
    }
	}


  public function add_comment($comment) {
    $this->db->insert('comment',$comment);
    return $this->db->insert_id();
  }
	
	
	public function delete_comment($commentid) {
		$this->db->where('commentid', $commentid);
		$this->db->delete('comment');
	}


  public function update_comment($comment) {
    $this->db->set('dishlistingid', $comment['dishlistingid']);
    $this->db->set('sentimenttype', $comment['sentimenttype']);
    if(isset($comment['imagename'])) {
      $this->db->set('imagename', $comment['imagename']);
    }
    $this->db->set('title', $comment['title']);
    $this->db->set('body', $comment['body']);
    $this->db->where('commentid', $comment['commentid']);
    $this->db->update('comment');
  }


  public function get_number_comments($restaurant) {
    $this->db->from('restaurant');
    $this->db->join('dish_listing', 'restaurant.restaurantid=dish_listing.restaurantid');
    $this->db->join('comment', 'dish_listing.dishlistingid=comment.dishlistingid');
    $this->db->where('restaurant.restaurantid', $restaurant->restaurantid);
    $this->db->select('comment.commentid');
    return $this->db->count_all_results();
  }


  public function get_all_comments($userid) {
		$query = $this->db->query("
		select comment.commentid, comment.imagename, comment.body, comment.datevisit, restaurant.restaurantname, restaurant.vicinity, dish_type.dishtype, dish.dishname from comment join dish_listing on comment.dishlistingid = dish_listing.dishlistingid join dish on dish_listing.dishid = dish.dishid left join dish_type on dish_listing.dishtypeid = dish_type.dishtypeid JOIN restaurant on dish_listing.restaurantid = restaurant.restaurantid where comment.userid = ".$userid." order by comment.commentid DESC
		");
    if($query->num_rows()>0) {
      return $query->result();
    }
    else {
      return null;
    }
  }


  public function get_specific_comment($commentid) {
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('comment.commentid', $commentid);
    $this->db->join('comment', 'user.userid=comment.userid');
    $this->db->join('dish_listing', 'dish_listing.dishlistingid=comment.dishlistingid');
    $this->db->join('dish', 'dish.dishid=dish_listing.dishid');
    $this->db->join('restaurant', 'restaurant.restaurantid=dish_listing.restaurantid');
    $this->db->limit('1');
    $query = $this->db->get();
    if($query->num_rows()>0) {
      foreach ($query->result() as $row) {
        return $row;
      }
    }
    else {
      return null;
    }
  }


}

?>
