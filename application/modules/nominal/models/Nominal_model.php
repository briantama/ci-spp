<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Nominal_model extends CI_Model{

	function ViewGetNominal(){
		return $this->db->get('m_nominalpayment');
	}	
}

?>