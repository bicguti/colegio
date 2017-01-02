<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_model extends CI_Model {
	public function getPlan()
	{
		$query = $this->db->get('PLAN');
		return $query->result_array();
	}
	

}

/* End of file Plan_model.php */
/* Location: ./application/models/Plan_model.php */