<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	
	public function index {
		
		$searchTerm = $_GET['term'];
		$ans = $this->dishtype_model->get_autocomplete_dish_type($searchTerm);
		echo $ans;
		
	}
	
	
}

?>