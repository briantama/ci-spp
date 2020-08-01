<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportsaving_model extends CI_Model{

	function ViewGetReportSaving(){
		return $this->db->get('T_Deposit');
	}	
}

?>