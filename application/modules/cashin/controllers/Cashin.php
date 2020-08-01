<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashin extends CI_Controller {

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
	function viewCashIn(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $limit = ($uri1 != "ALL") ? "LIMIT ". $uri1 : "";
      $qry   = $this->db->query("SELECT * FROM m_cashin ".$limit." ");
      if ($qry->num_rows() > 0) {
        $res = $qry->result();
        $this->jcode($res);
      }
      else
      {
        $str = "";
        $this->jcode($str);
      }
      exit();
    }
    //get number id supplier
    else if(trim($uri) == "getnumber"){
      $xdate = date('ym');
      $qry = $this->db->query("
                               SELECT  CONCAT('CSI-".$xdate."-',LPAD(CAST(CAST(COALESCE(MAX(RIGHT(cashinid, 6)), '000000') AS INTEGER) + 1 as integer)::text, 6,'0')) as getid 
                                    FROM    m_cashin
                               ");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        echo json_encode($res);
      }
      else{
        $str["getid"]  = "";
        $this->jcode($str);
      }
      exit();
    }
    else if (trim($uri) == "save") {

      //post file
      $cashinid    = htmlspecialchars($_POST['cashinid']);
      $cashdate    = htmlspecialchars($_POST['cashdate']);
      $cashamount  = htmlspecialchars($_POST['cashamount']);
      $desc        = htmlspecialchars(ucwords(strtolower($_POST['desc'])));

      $res = $this->db->query("SELECT cashinid FROM m_cashin WHERE cashinid = '".$cashinid."'");
          if ($res->num_rows() == 0) {
						
            $this->db->query("INSERT INTO m_cashin
																		( cashinid, cashdate, cashamount, description,
                                      isactive, entryby, entrydate, lastupdateby, lastupdatedate ) 
															VALUES 
																		( '".$cashinid."', '".$cashdate."', ".$cashamount.",  '".$desc."',
                                      'Y', '".$usernm."', '".$datetm."', '".$usernm."',  '".$datetm."')	
														");
						$msg = "Save";
          }
					else {
						$this->db->query("UPDATE 	m_cashin
																			SET			cashdate                = '".$cashdate."',
                                              cashamount              = ".$cashamount.",
                                              description             = '".$desc."',
																							isactive 								= 'Y',
																							lastupdatedate      		= '".$datetm."',
																							lastupdateby        		= '".$usernm."'
																			WHERE 	cashinid  			        = '".$cashinid."'
														");
						$msg = "Update";
          }
        
      
      $jeson['status']   = "ok";
      $jeson['id']       = $cashinid;
      $jeson['msg']      = "Successfuly ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if(trim($uri) == "print"){
      $this->load->model('Cashin_model');
      $data['title']        = 'Print Data Cash In';
      $data['isi']          = 'cashin/Cashin_print';
      $data['datacash']     = $this->Cashin_model->ViewGetcashIn()->result();
      $this->load->view('cashin/Cashin_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Cashin_model');
      $data['title']        = 'Ecxport Data Cash In';
      $data['isi']          = 'cashin/Cashin_export';
      $data['filenm']       = 'master-class';
      $data['datacash']     = $this->Cashin_model->ViewGetcashIn()->result();
      $this->load->view('cashin/Cashin_export',$data);
    }
    else if (trim($uri) == "delete") {

      //post file
      $cashinid     = $_POST['cashinid'];

        $this->db->query("UPDATE  m_cashin 
                          SET     isactive        = 'N',
                                  lastupdatedate  = '".$datetm."',
                                  lastupdateby    = '".$usernm."' 
                          WHERE   cashinid        = '".$cashinid."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else{
      $this->load->model('Cashin_model');
      $data['title']        = 'Data Cash In';
      $data['isi']          = 'cashin/Cashin_view';
      $data['dataclass']    = $this->Cashin_model->ViewGetcashIn()->result();
      $this->load->view('cashin/Cashin_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}