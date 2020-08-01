<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Setupprofile_model extends CI_Model{

	function ViewGetSetupprofile(){
		return $this->db->get('m_setupprofile');
	}	
}

?>