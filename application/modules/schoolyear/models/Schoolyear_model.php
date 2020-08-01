<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Schoolyear_model extends CI_Model{

	function ViewGetSchoolyear(){
		return $this->db->get('m_schoolyear');
	}	
}

?>