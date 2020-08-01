<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_model extends CI_Model{

	function ViewGetClass(){
		return $this->db->get('m_class');
	}	
}

?>