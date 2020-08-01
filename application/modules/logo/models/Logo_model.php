<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Logo_model extends CI_Model{

	function getLogo(){		
		return $this->db->get('m_setupprofile');
	}
}

?>