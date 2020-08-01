<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

	function ViewGetUser($where,$table){
		return $this->db->get_where($table,$where);
	}	
}

?>