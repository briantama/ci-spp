<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportcash_model extends CI_Model{

	function ViewGetreportCash(){
		return $this->db->get('m_cashin');
	}	
}

?>