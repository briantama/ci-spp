<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Majors_model extends CI_Model{

	function ViewGetMajors(){
		return $this->db->get('m_majors');
	}	
}

?>