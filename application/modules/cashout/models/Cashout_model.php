<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashout_model extends CI_Model{

	function ViewGetcashOut(){
		return $this->db->get('m_cashout');
	}	
}

?>