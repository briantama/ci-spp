<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model{

	function ViewGetStudent(){
		return $this->db->get('m_student');
	}	
}

?>