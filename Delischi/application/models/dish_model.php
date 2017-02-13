<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dish_model extends CI_Model {


  public function __construct() {

    parent::__construct();

  }
	
	
	public function get_explore_search($searchTerm) {
		$query = $this->db->query("	
		select dish.dishname, count(comment.dishlistingid) as totalcomments, count(CASE WHEN comment.sentimenttype = 'positive' THEN 1 END) as totallikes, count(CASE WHEN comment.sentimenttype = 'neutral' THEN 1 END) as totaneutrals, count(CASE WHEN comment.sentimenttype = 'negative' THEN 1 END) as totaldislikes, restaurant.restaurantid, restaurant.restaurantname, restaurant.vicinity, min(comment.imagename) as imagename, dish_type.dishtype, dish_listing.dishlistingid from comment join dish_listing on comment.dishlistingid = dish_listing.dishlistingid join dish on dish.dishid = dish_listing.dishid join restaurant on restaurant.restaurantid = dish_listing.restaurantid left join dish_type on dish_listing.dishtypeid = dish_type.dishtypeid where restaurant.restaurantname like '%".$searchTerm."%' or dish.dishname like '%".$searchTerm."%' GROUP by dish.dishname, restaurant.restaurantid, dish_listing.dishlistingid ORDER by dish.dishname
		");
		if($query->num_rows()>0) {
      return $query->result();
    }
	}
	
	
	public function get_home_dishes($homePlace) {
		$query = $this->db->query("
		select dish.dishname, count(comment.dishlistingid) as totalcomments, count(CASE WHEN comment.sentimenttype = 'positive' THEN 1 END) as totallikes, count(CASE WHEN comment.sentimenttype = 'neutral' THEN 1 END) as totaneutrals, count(CASE WHEN comment.sentimenttype = 'negative' THEN 1 END) as totaldislikes, restaurant.restaurantid, restaurant.restaurantname, restaurant.vicinity, min(comment.imagename) as imagename, dish_type.dishtype, dish_listing.dishlistingid from comment join dish_listing on comment.dishlistingid = dish_listing.dishlistingid join dish on  dish.dishid = dish_listing.dishid join restaurant on restaurant.restaurantid = dish_listing.restaurantid left join dish_type on dish_listing.dishtypeid = dish_type.dishtypeid where match (restaurant.vicinity) against ('".$homePlace."') GROUP by dish.dishname, restaurant.restaurantid, dish_listing.dishlistingid ORDER by dish.dishname
		");
		if($query->num_rows()>0) {
      return $query->result();
    }	
	}
	
	
	public function get_explore_item_similars($dishlistingid) {
		$this->db->from('dish_listing');
    $this->db->where('dishlistingid', $dishlistingid);
		$this->db->join('dish', 'dish_listing.dishid=dish.dishid');
		$this->db->select('*');
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) {
      foreach($query->result() as $row) {
        $dishname = $row->dishname;
        $restaurantid = $row->restaurantid;
				$query = $this->db->query("
					select min(comment.imagename) as imagename, dish.dishname, restaurant.restaurantname, dish_listing.dishlistingid, sum(dish_listing.likes) as totallikes from comment join dish_listing on comment.dishlistingid = dish_listing.dishlistingid join dish on dish_listing.dishid = dish.dishid join restaurant on dish_listing.restaurantid = restaurant.restaurantid where dish_listing.dishlistingid not in ('".$dishlistingid."') and MATCH(dishname) AGAINST('".$dishname."') GROUP by dish.dishid, restaurant.restaurantid, dish_listing.dishlistingid order by totallikes DESC limit 3
				");
				if($query->num_rows()>0) {
					return $query->result();
				}		
      }
    }
	}
	
	
	public function delete_menu_item($dishlistingid) {
		$this->db->where('dishlistingid', $dishlistingid);
		$this->db->delete('comment');
		$this->db->where('dishlistingid', $dishlistingid);
		$this->db->delete('dish_listing');
	}
	

  public function update_sentiment_numbers($dish_listing_id) {
    // count positives
    $query = $this->db->query('
      select count(*) as likes
      from comment, dish_listing
      where comment.dishlistingid=dish_listing.dishlistingid
      and dish_listing.dishlistingid="'.$this->db->escape($dish_listing_id).'"
      and comment.sentimenttype = "positive"
    ');
    foreach ($query->result() as $row) {
      $number_likes = $row->likes;
    }
    // count neutrals
    $query = $this->db->query('
      select count(*) as neutrals
      from comment, dish_listing
      where comment.dishlistingid=dish_listing.dishlistingid
      and dish_listing.dishlistingid="'.$this->db->escape($dish_listing_id).'"
      and comment.sentimenttype = "neutral"
    ');
    foreach ($query->result() as $row) {
      $number_neutrals = $row->neutrals;
    }
    // count negatives
    $query = $this->db->query('
      select count(*) as dislikes
      from comment, dish_listing
      where comment.dishlistingid=dish_listing.dishlistingid
      and dish_listing.dishlistingid="'.$this->db->escape($dish_listing_id).'"
      and comment.sentimenttype = "negative"
    ');
    foreach ($query->result() as $row) {
      $number_dislikes = $row->dislikes;
    }
    // update likes and dislikes
    $this->db->set('likes', $number_likes);
    $this->db->set('neutrals', $number_neutrals);
    $this->db->set('dislikes', $number_dislikes);
    $this->db->where('dishlistingid', $dish_listing_id);
    $this->db->update('dish_listing');
  }


  public function get_sentiment_stats($restaurant) {
    $query = $this->db->query("
		select COUNT(CASE WHEN comment.sentimenttype = 'positive' THEN 1 END) AS sumlikes, COUNT(CASE WHEN comment.sentimenttype = 'neutral' THEN 1 END) AS sumneutrals, COUNT(CASE WHEN comment.sentimenttype = 'negative' THEN 1 END) AS sumdislikes from restaurant, dish_listing, comment where restaurant.restaurantid='".$restaurant->restaurantid."' and restaurant.restaurantid=dish_listing.restaurantid and comment.dishlistingid = dish_listing.dishlistingid limit 1
		");
    foreach ($query->result() as $row) {
      $opinion_stats = array (
        'sumlikes' => $row->sumlikes,
        'sumneutrals' => $row->sumneutrals,
        'sumdislikes' => $row->sumdislikes
      );
    }
    return $opinion_stats;
  }


  public function get_menu_dishes($restaurant_id) {
    $this->db->from('dish_listing');
    $this->db->where('dish_listing.restaurantid', $restaurant_id);
    $this->db->join('dish', 'dish.dishid=dish_listing.dishid');
    $this->db->join('dish_type', 'dish_type.dishtypeid=dish_listing.dishtypeid');
    $this->db->order_by('dish.dishname', 'ASC');
    $this->db->order_by('dish_type.dishtype', 'ASC');
    $query = $this->db->get();
    if($query->num_rows()>0) {
      return $query->result();
    }
    else {
      return null;
    }
  }


  public function get_number_dishes_mentioned($restaurant) {
    $this->db->from('restaurant');
    $this->db->where('restaurant.restaurantid', $restaurant->restaurantid);
    $this->db->join('dish_listing', 'restaurant.restaurantid=dish_listing.restaurantid');
    $this->db->join('comment', 'dish_listing.dishlistingid=comment.dishlistingid');
    $this->db->select('dish_listing.dishid');
    $this->db->distinct();
    return $this->db->count_all_results();
  }


  public function get_dish_id($dishname) {
    $this->db->from('dish');
    $this->db->where('dishname', $dishname);
    $this->db->select('dishid');
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) { 
      foreach($query->result() as $row) {
        return $row->dishid;
      }
    }
    else { 
      $this->db->query("insert into `dish`(`dishname`) values ('".$this->db->escape_str($dishname)."')");
      return $this->db->insert_id();
    }
  }


  public function get_dish_listing_id($dish_listing) {
    $this->db->from('dish_listing');
    $this->db->where('dishid', $dish_listing['dishid']);
    $this->db->where('restaurantid', $dish_listing['restaurantid']);
    $this->db->limit(1);
    $query = $this->db->get();
    if($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        return $row->dishlistingid;
      }
    }
    else {
      $this->db->insert('dish_listing',$dish_listing);
      return $this->db->insert_id();
    }
  }


  public function get_number_dishes_eaten($userid) {
    $this->db->from('dish');
    $this->db->join('dish_listing', 'dish.dishid=dish_listing.dishid');
    $this->db->join('comment', 'dish_listing.dishlistingid=comment.dishlistingid');
    $this->db->join('user', 'user.userid=comment.userid');
    $this->db->where('user.userid', $userid);
    return $this->db->count_all_results();
  }

	
	
	public function get_explore_dishes() {
    $query = $this->db->query("
		select min(comment.imagename) as imagename, dish.dishname, dish_type.dishtype, restaurant.restaurantid, restaurant.restaurantname, restaurant.vicinity, dish_listing.dishlistingid, count(comment.dishlistingid) as totalcomments, count(CASE WHEN comment.sentimenttype = 'positive' THEN 1 END) as totallikes, count(CASE WHEN comment.sentimenttype = 'neutral' THEN 1 END) as totaneutrals, count(CASE WHEN comment.sentimenttype = 'negative' THEN 1 END) as totaldislikes from comment join dish_listing on comment.dishlistingid = dish_listing.dishlistingid join dish on dish_listing.dishid = dish.dishid join restaurant on dish_listing.restaurantid = restaurant.restaurantid left join dish_type on dish_listing.dishtypeid = dish_type.dishtypeid GROUP by dish.dishid, restaurant.restaurantid, dish_listing.dishlistingid order by totallikes DESC
		");
		if($query->num_rows()>0) {
      return $query->result();
    }		
	}
	
	
	public function get_specific_explore_item_img($dishlistingid) {
		$query = $this->db->query("
		select distinct(comment.imagename) from dish_listing INNER JOIN comment ON dish_listing.dishlistingid=comment.dishlistingid WHERE dish_listing.dishlistingid = ".$dishlistingid
		);
		if($query->num_rows()>0) {
      return $query->result();
    }
	}
	
	
	public function get_specific_explore_item_pt1($dishlistingid) {
		$query = $this->db->query("
		select min(comment.imagename) as imagename, dish.dishname, dish_type.dishtype, dish_listing.dishdescription, restaurant.restaurantname, restaurant.restaurantid, restaurant.vicinity from dish_listing INNER JOIN dish ON dish_listing.dishid=dish.dishid LEFT JOIN dish_type ON dish_listing.dishtypeid=dish_type.dishtypeid INNER JOIN restaurant ON dish_listing.restaurantid=restaurant.restaurantid INNER JOIN comment ON dish_listing.dishlistingid=comment.dishlistingid WHERE dish_listing.dishlistingid = ".$dishlistingid
		);
		if($query->num_rows()>0) {
      return $query->result();
    }		
	}		
	
	
	public function get_specific_explore_item_pt2($dishlistingid) {
    $query = $this->db->query("
		select comment.sentimenttype, comment.body, comment.datevisit, user.imagepath, user.firstname, user.lastname from dish_listing INNER JOIN comment ON dish_listing.dishlistingid=comment.dishlistingid INNER JOIN user ON comment.userid=user.userid WHERE dish_listing.dishlistingid = ".$dishlistingid." ORDER by comment.datevisit DESC, comment.sentimenttype ASC
		");
		if($query->num_rows()>0) {
      return $query->result();
    }		
	}
	
	
	public function get_menu_items_stats($restaurant) {
    $query = $this->db->query("
		select distinct(dish.dishname), count(comment.commentid) as sumcomments, count(CASE WHEN comment.sentimenttype = 'positive' THEN 1 END) as sumlikes, count(CASE WHEN comment.sentimenttype = 'neutral' THEN 1 END) as sumneutrals, count(CASE WHEN comment.sentimenttype = 'negative' THEN 1 END) as sumdislikes from comment RIGHT JOIN dish_listing on comment.dishlistingid = dish_listing.dishlistingid JOIN dish on dish_listing.dishid = dish.dishid JOIN restaurant on dish_listing.restaurantid = restaurant.restaurantid WHERE restaurant.restaurantid = ".$restaurant->restaurantid." GROUP by dish_listing.dishid ORDER BY dish.dishname DESC
		");
		if($query->num_rows()>0) {
      return $query->result();
    }		
	}
	
	
	public function get_popularity_short($restaurant) {
		$query = $this->db->query("
		select distinct(dish.dishname), count(CASE WHEN comment.sentimenttype = 'positive' THEN 1 END) as totallikes, count(CASE WHEN comment.sentimenttype = 'neutral' THEN 1 END) as totalneutrals, count(CASE WHEN comment.sentimenttype = 'negative' THEN 1 END) as totaldislikes from comment RIGHT JOIN dish_listing on comment.dishlistingid = dish_listing.dishlistingid JOIN dish on dish_listing.dishid = dish.dishid JOIN restaurant on dish_listing.restaurantid = restaurant.restaurantid WHERE restaurant.restaurantid = ".$restaurant->restaurantid." GROUP by dish_listing.dishid ORDER BY totallikes DESC, totaldislikes ASC
		");
		if($query->num_rows()>0) {
      return $query->result();
    }		
	}
	
	
	public function get_comments_short($restaurant) {
		$query = $this->db->query("
		select distinct(dish.dishname), count(comment.commentid) as totalcomments from comment RIGHT JOIN dish_listing on comment.dishlistingid = dish_listing.dishlistingid JOIN dish on dish_listing.dishid = dish.dishid JOIN restaurant on dish_listing.restaurantid = restaurant.restaurantid WHERE restaurant.restaurantid = ".$restaurant->restaurantid." GROUP by dish_listing.dishid ORDER BY totalcomments DESC
		");
		if($query->num_rows()>0) {
      return $query->result();
    }		
	}



}

?>
