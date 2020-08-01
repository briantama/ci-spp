<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportcashin_model extends CI_Model{

	function ViewGetReportCashIn(){
		return $this->db->get('m_cashin');
	}	
}

?>