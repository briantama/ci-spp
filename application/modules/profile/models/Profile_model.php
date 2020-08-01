<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model{

	function getAdmin($where,$table){		
		return $this->db->get_where($table,$where);
	}
}

?>