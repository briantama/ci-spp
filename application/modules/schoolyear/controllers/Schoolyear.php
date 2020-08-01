<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schoolyear extends CI_Controller {

	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index() {
		$data=array('title'=>'Apps Bryn - Halaman Administrator',
      					 'isi' =>'dasbor/dasbor_view'
      						);
		$this->load->view('layout/wrapper',$data);	
	}


	//galeri widget
	function viewSchoolyear(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $limit = ($uri1 != "ALL") ? "LIMIT ". $uri1 : "";
      $qry   = $this->db->query("SELECT * FROM m_schoolyear ".$limit." ");
      if ($qry->num_rows() > 0) {
        $res = $qry->result();
        $this->jcode($res);
      }
      else
      {
        $str = '';
        $this->jcode($str);
      }
      exit();
    }
    else if (trim($uri) == "save") {

      //post file
      $scyaer      = htmlspecialchars($_POST['schoolyear']);
      $desc        = htmlspecialchars(ucwords(strtolower($_POST['desc'])));

      $res = $this->db->query("SELECT schoolyear FROM m_schoolyear WHERE schoolyear = '".$scyaer."' ");
          if ($res->num_rows() == 0) {
						
            $this->db->query("INSERT INTO m_schoolyear
																		( schoolyear, description,
                                      isactive, entryby, entrydate, lastupdateby, lastupdatedate ) 
															VALUES 
																		( '".$scyaer."', '".$desc."',
                                      'Y', '".$usernm."', '".$datetm."', '".$usernm."',  '".$datetm."')	
														");
						$msg = "Save";
          }
					else {
						$this->db->query("UPDATE 	m_schoolyear
																			SET			description             = '".$desc."',
																							isactive 								= 'Y',
																							lastupdatedate      		= '".$datetm."',
																							lastupdateby        		= '".$usernm."'
																			WHERE 	schoolyear	            = '".$scyaer."'
														");
						$msg = "Update";
          }
        
      
      $jeson['status']   = "ok";
      $jeson['id']       = $scyaer;
      $jeson['msg']      = "Successfuly ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if(trim($uri) == "print"){
      $this->load->model('Schoolyear_model');
      $data['title']        = 'Print Data School Year';
      $data['isi']          = 'schoolyear/Schoolyear_print';
      $data['datayear']     = $this->Schoolyear_model->ViewGetSchoolyear()->result();
      $this->load->view('schoolyear/Schoolyear_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Schoolyear_model');
      $data['title']        = 'Export Data School Year';
      $data['isi']          = 'schoolyear/Schoolyear_export';
      $data['filenm']       = 'master-school-yaer';
      $data['datayear']     = $this->Schoolyear_model->ViewGetSchoolyear()->result();
      $this->load->view('schoolyear/Schoolyear_export',$data);
    }
    else if (trim($uri) == "delete") {

      //post file
      $scyear     = $_POST['schoolyear'];

        $this->db->query("UPDATE  m_schoolyear 
                          SET     isactive        = 'N',
                                  lastupdatedate  = '".$datetm."',
                                  lastupdateby    = '".$usernm."' 
                          WHERE   schoolyear      = '".$scyear."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else{
      $this->load->model('Schoolyear_model');
      $data['title']        = 'Data School Year';
      $data['isi']          = 'schoolyear/Schoolyear_view';
      $data['dataclass']    = $this->Schoolyear_model->ViewGetSchoolyear()->result();
      $this->load->view('schoolyear/Schoolyear_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}