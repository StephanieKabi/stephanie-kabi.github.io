<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {


  public function __construct() {

      parent::__construct();

  }
	
	
	public function get_total_users() {
		$query = $this->db->query("select count(*) as totalusers from user");
		if($query->num_rows()>0) {
      return $query->result();
    }
	}
	
	
	public function delete_user($userid) {
		$this->db->where('userid', $userid);
		$this->db->delete('login_credentials');
		$this->db->where('userid', $userid);
		$this->db->delete('user');
	}
	
	
	public function get_users_per_group() {
    $this->db->from('user_type');
    $this->db->join('user', 'user_type.usertypeid=user.usertypeid');
		$this->db->select('user_type.usertype, count(user.username) as totalusers');
    $this->db->group_by('user_type.usertypeid');
		$this->db->order_by('user_type.usertypeid', 'DESC');
    $query = $this->db->get();
    if($query->num_rows()>0) {
      return $query->result();
    }
	}
	
	
	public function get_hash_value($hash) {
		$this -> db -> select('*');
    $this -> db -> from('login_credentials');
    $this -> db -> where('hash', $hash);
    $this -> db -> limit(1);
    $query = $this -> db -> get();
    if($query->num_rows()>0) {
      return $query->result();
    }
    else {
      return null;
    }
	}
	
	
	public function verify_user($emailaddress) {
    $this->db->set('is_verified', '1');
		$this->db->where('emailaddress', $emailaddress);
		$this->db->update('login_credentials');
	}


  public function login($passes) {
    $this -> db -> select('*');
    $this -> db -> from('login_credentials');
    $this -> db -> where('emailaddress', $passes['emailaddress']);
    //$this -> db -> where('is_verified', '1');
    $this -> db -> limit(1);
    $query = $this -> db -> get();
    if($query->num_rows()>0) {
      return $query->result();
    }
    else {
      return null;
    }
  }


  public function add_user($user,$emailaddress) {
    $this->db->select('*');
    $this->db->from('user');
    $this->db->join('login_credentials', 'user.userid=login_credentials.userid');
    $this->db->where('login_credentials.emailaddress', $emailaddress);
    $query = $this->db->get();
    if($query->num_rows() > 0) {// If record exists
      foreach ($query->result() as $row) {
        return $row->userid;
      }
    }
    else { // If record does not exist
      $this->db->insert('user',$user);
      return $this->db->insert_id();
    }
  }


  public function add_login_credentials($login_credentials) {
    return $this->db->insert('login_credentials',$login_credentials) ? true : false;
  }


  public function get_specific_user($userid) {
    $this->db->where('user.userid', $userid);
    $this->db->select('*');
    $this->db->from('user_type');
    $this->db->join('user', 'user_type.usertypeid=user.usertypeid');
    $this->db->join('login_credentials', 'user.userid=login_credentials.userid');
    $query = $this->db->get();
    foreach ($query->result() as $row) {
      return $row;
    }
  }


  public function update_user($user,$login_credentials) {
    $this->db->set('firstname', $user['firstname']);
    $this->db->set('lastname', $user['lastname']);
    if (isset($user['imagepath'])) {
      $this->db->set('imagepath', $user['imagepath']);
    }
    $this->db->set('username', $user['username']);
    $this->db->where('userid', $user['userid']);
    $this->db->update('user');
    $this->db->set('encpassword', $login_credentials['encpassword']);
    $this->db->where('userid', $login_credentials['userid']);
    $this->db->update('login_credentials');
  }


  public function get_all_users() {
    $this->db->select('*');
    $this->db->from('user_type');
    $this->db->join('user', 'user_type.usertypeid=user.usertypeid');
    $this->db->join('login_credentials', 'user.userid=login_credentials.userid');
    $this->db->order_by('user.firstname', 'ASC');
    $this->db->order_by('user.lastname', 'ASC');
    //$this->db->order_by('user_type.usertype', 'ASC');
    $query = $this->db->get();
    if($query->num_rows()>0) {
      return $query->result();
    }
    else {
      return null;
    }
  }


}

?>
