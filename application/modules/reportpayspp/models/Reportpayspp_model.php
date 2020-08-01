<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportpayspp_model extends CI_Model{

	function ViewGetReportpayspp(){
		return $this->db->get('m_paymentspp');
	}	
}

?>