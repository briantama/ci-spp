<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data=array('title'=>'Login Administrator');
		$this->load->view('login_view',$data);	
	}


	function getlogin(){
		$log      = array();
		$this->load->model('M_login');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => $password,
			'isactive' => 'Y'
			//'level' => 'admin'
			);
		$cek = $this->M_login->cek_login('m_admin',$where);
		if($cek->num_rows() > 0){
			$rows = $cek->row();
			$data_session = array(
				'nama'   => $username,
				'status' => "login",
				'superuser' => $rows->superuser,
				);

			$this->session->set_userdata($data_session);
			//"Login Berhasil";
		    $_log['log']['valid']			= "1";
			$_log['log']['notif']		    = "Login Success";

			//redirect(base_url("admin/dasbor"));

		}else{
			$data=array('title'=>'Login Administrator',
						'isi'  =>'admin/login_view');

			//login gagal
		    $_log['log']['valid']			= "0";
			$_log['log']['notif']		    = "Username or Password Incorect";
		}

		$this->jcode($_log);
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}

	public function jcode($data) {
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}
