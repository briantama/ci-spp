<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportcashout_model extends CI_Model{

	function ViewGetreportCashout(){
		return $this->db->get('m_cashin');
	}	
}

?>