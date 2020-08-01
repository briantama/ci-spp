<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index() {
		$data=array('title'=>'Apps Savings - Halaman Administrator',
					 'isi' =>'dasbor/dasbor_view'
						);
		$this->load->view('layout/wrapper',$data);	
	}


	//user admin
	function viewUser(){

    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    //uri url admin/a_artikel/tampil_artikel/(uri3)/value(uri4)
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	  
	$datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

	    if(trim($uri) == "view"){
	      $limit = ($uri1 != "ALL") ? "LIMIT ". $uri1 : "";
          
          $cek = $this->db->query("SELECT * FROM m_admin WHERE username = '".$usernm."'")->row();
          if(trim($cek->superuser) == "Y"){

	        $qry = $this->db->query("
	        						SELECT  adminid, adminname, dateofbirth, email, username, password, 
											superuser, isactive, entryby, entrydate, lastupdateby, lastupdatedate
									FROM   (
									
			        						SELECT 	adminid, adminname, dateofbirth, email, username, password, 
													superuser, isactive, entryby, entrydate, lastupdateby, lastupdatedate
			        						FROM 	m_admin WHERE username = '".$usernm."'
			      						     
			      						    UNION ALL

			      						    SELECT 	adminid, adminname, dateofbirth, email, username, password, 
													superuser, isactive, entryby, entrydate, lastupdateby, lastupdatedate
											FROM 	m_admin WHERE superuser ='N'

			      						    ) XZ
	      						     ".$limit."
	      						");

		      if ($qry->num_rows() > 0) {
		        $res = $qry->result();
		        $this->jcode($res);
		      }
		      else{
		        $str = "";
		        $this->jcode($str);
		      }
		      exit();
	      }
	      else{

	      	$qry = $this->db->query("SELECT * FROM m_admin WHERE username = '".$usernm."' ".$limit." ");

		      if ($qry->num_rows() > 0) {
		        $res = $qry->result();
		        $this->jcode($res);
		      }
		      else{
		        $str = "";
		        $this->jcode($str);
		      }
		      exit();

	      }

	    }
	    else if (trim($uri) == "save") {

	    	//post data
	    	$adminid   = $_POST["idadminx"];
	    	$adminnm   = $_POST["adminname"];
      		$email     = $_POST["email"];
      		$dateof    = $_POST["date_of"];
      		$username  = $_POST["username"];
      		$password  = $_POST["password"];
      		$repassword= $_POST["repassword"];
      		$supersr   = $_POST["supuser"];


			
			if(trim($password) != trim($repassword) ){
					$jeson['status']   = "failed";
					$jeson['id']       = $adminid;
					$jeson['msg']      = "password Not same...!!!";
					$jeson["focus"]    = "repassword";
					header('Content-Type: text/html');
					echo json_encode($jeson);
					exit;
			}
		    else
		    {
				$res = $this->db->query("SELECT adminid FROM m_admin WHERE adminid = '".$adminid."'");
					if ($res->num_rows() == 0) {

						if(trim($password) == "" || trim($repassword) == ""){
							$jeson['status']   = "failed";
							$jeson['id']       = $adminid;
							$jeson['msg']      = "Please Insert password Or Re password...!!!";
							$jeson["focus"]    = "password";
							header('Content-Type: text/html');
							echo json_encode($jeson);
							exit;
						}

						//cek username
						$cek     = $this->db->query("SELECT username FROM m_admin WHERE username = '".trim($username)."'");
						if ($cek->num_rows() > 0) {
							$jeson['status']   = "failed";
							$jeson['id']       = $adminid;
							$jeson['msg']      = "username ".$username." Already Used...!!!";
							$jeson["focus"]    = "username";
							header('Content-Type: text/html');
							echo json_encode($jeson);
							exit;
						}

						$this->db->query("	
											INSERT INTO m_admin
											( adminname, dateofbirth, email, username, password, 
											  superuser, isactive, entryby, entrydate, lastupdateby, lastupdatedate ) 
											VALUES 
											( '".$adminnm."', '".$dateof."', '".$email."', '".trim($username)."', '".$password."',    
											  '".$supersr."', 'Y', '".$usernm."', '".$datetm."', '".$usernm."', '".$datetm."')	
										");
						$msg = "Save";
					} 
					else 
					{
							$cekpswd = (trim($password) != "") ? "password = '".$password."'," : "";

							$this->db->query("  UPDATE 	m_admin
												SET		adminname     				= '".$adminnm."',
														dateofbirth    		    	= '".$dateof."',
														email         		    	= '".$email."',
														username       		    	= '".$username."',
														".$cekpswd."
														superuser      		    	= '".$supersr."',
														isactive 					= 'Y',
														lastupdatedate      		= '".$datetm."',
														lastupdateby        		= '".$usernm."'
												WHERE 	adminid			  			= '".$adminid."'
																		
											");
							$msg = "Update";
						

					}
							
						
				$jeson['status']   = "ok";
				$jeson['id']       = $adminid;
				$jeson['msg']      = "User Successfuly ".$msg;
				$jeson['notif']    = "Successfuly Saved !!!";
				header('Content-Type: text/html');
				echo json_encode($jeson);
				exit;
			}
				
	    }
	    else if (trim($uri) == "delete") {
	        $this->db->query("UPDATE  m_admin 
	                          SET     isactive        ='N',
	                                  lastupdatedate  = '".$datetm."',
	                                  lastupdateby    = '".$usernm."'
	                          WHERE   adminid         = '".$uri1."'
	                        ");
	        
	        $ret_arr['status']  = "ok";
	        $ret_arr['caption'] = "Delete Success !!!";
	        $this->jcode($ret_arr);
	        exit();
	    }
	    else{
	      $this->load->model('User_model');
	       $where = array(
				        'username' => $usernm
				        );
	      $data['title']        = 'Data User';
	      $data['isi']          = 'user/user_view';
	      $data['dataAdmin']    = $this->User_model->ViewGetUser($where, "m_admin")->result();  
	      $this->load->view('user/user_view',$data);
	    }
	}



	public function jcode($data) {
	    header('Content-Type: application/json');
	    echo json_encode($data);
	}
  


}
