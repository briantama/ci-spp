<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashin_model extends CI_Model{

	function ViewGetcashIn(){
		return $this->db->get('m_cashin');
	}	
}

?>