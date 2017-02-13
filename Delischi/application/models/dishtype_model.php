<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dishtype_model extends CI_Model {


  public function __construct() {

    parent::__construct();

  }
		
	
	public function get_all_dishtypes() {
    $this->db->from('dish_type');
    $this->db->order_by('dishtype', 'ASC');
    $query = $this->db->get();
    if($query->num_rows() > 0) { // If record exists
      return $query->result();
    }
    else {
      return NULL;
    }
	}


  public function get_autocomplete_dish_type($searchTerm) {
		$this->db->from('dish_type');
		$this->db->like('dishtype', $searchTerm);
		$this->db->order_by('dishtype', 'ASC');
    $query = $this->db->get();
    if($query->num_rows() > 0) { // If record exists
      //return $query->result();
			foreach ($query->result_array() as $row){
        $row_set[] = htmlentities(stripslashes($row['dishtype'])); //build an array
      }
      echo json_encode($row_set); //format the array into json data
    }
    else {
      return NULL;
    }
  }


  public function get_dish_type_id($dishtype) {
    $this->db->select('dishtypeid');
    $this->db->from('dish_type');
    $this->db->where('dishtype', $dishtype);
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) { // If record exists
      foreach($query->result() as $row) {
        return $row->dishtypeid;
      }
    }
    else { // If record does not exist
      $this->db->insert('dishtype', $dishtype);
      return $this->db->insert_id();
    }

  }
	
	
	public function get_cuisines_eaten($userid) {
    $this->db->from('dish_type');
    $this->db->join('dish_listing', 'dish_type.dishtypeid=dish_listing.dishtypeid');
    $this->db->join('comment', 'dish_listing.dishlistingid=comment.dishlistingid');
    $this->db->join('user', 'user.userid=comment.userid');
    $this->db->where('user.userid', $userid);
    return $this->db->count_all_results();
  }


}
