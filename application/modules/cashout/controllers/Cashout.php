<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashout extends CI_Controller {

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
	function viewCashOut(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $limit = ($uri1 != "ALL") ? "LIMIT ". $uri1 : "";
      $qry   = $this->db->query("SELECT * FROM m_cashout ".$limit." ");
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
    //get number 
    else if(trim($uri) == "getnumber"){
      $xdate = date('ym');
      $qry = $this->db->query("
                               SELECT  CONCAT('CSO-".$xdate."-',LPAD(CAST(CAST(COALESCE(MAX(RIGHT(cashoutid, 6)), '000000') AS INTEGER) + 1 as integer)::text, 6,'0')) as getid 
                                    FROM    m_cashout
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

    else if(trim($uri) == "total"){
      $xdate = date('ym');
      $qry = $this->db->query("
                              SELECT SUM(COALESCE(totalin, 0)) - SUM(COALESCE(totalout, 0))  as totalin
                              FROM (
                                SELECT  SUM(cashamount) as totalin , 0 as totalout
                                FROM    m_cashin
                                WHERE   isactive = 'Y'

                                UNION ALL

                                SELECT  0 as totalin, SUM(cashamountout) as totalout 
                                FROM    m_cashout
                                WHERE   isactive = 'Y'
                                ) XZ

                               ");
      if ($qry->num_rows() > 0) {
        $res = $qry->row();
        echo json_encode($res);
      }
      else{
        $str["totalin"]  = "";
        $this->jcode($str);
      }
      exit();
    }
    else if (trim($uri) == "save") {

      //post file
      $cashoutid   = htmlspecialchars($_POST['cashoutid']);
      $cashdate    = htmlspecialchars($_POST['cashdate']);
      $cashamount  = htmlspecialchars($_POST['cashamount']);
      $desc        = htmlspecialchars(ucwords(strtolower($_POST['desc'])));

      $res = $this->db->query("SELECT cashoutid FROM m_cashout WHERE cashoutid = '".$cashoutid."'");
          if ($res->num_rows() == 0) {
						
            $this->db->query("INSERT INTO m_cashout
																		( cashoutid, cashdate, cashamountout, description,
                                      isactive, entryby, entrydate, lastupdateby, lastupdatedate ) 
															VALUES 
																		( '".$cashoutid."', '".$cashdate."', ".$cashamount.",  '".$desc."',
                                      'Y', '".$usernm."', '".$datetm."', '".$usernm."',  '".$datetm."')	
														");
						$msg = "Save";
          }
					else {
						$this->db->query("UPDATE 	m_cashout
																			SET			cashdate                = '".$cashdate."',
                                              cashamountout           = ".$cashamount.",
                                              description             = '".$desc."',
																							isactive 								= 'Y',
																							lastupdatedate      		= '".$datetm."',
																							lastupdateby        		= '".$usernm."'
																			WHERE 	cashoutid  			        = '".$cashoutid."'
														");
						$msg = "Update";
          }
        
      
      $jeson['status']   = "ok";
      $jeson['id']       = $cashoutid;
      $jeson['msg']      = "Successfuly ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if(trim($uri) == "print"){
      $this->load->model('Cashout_model');
      $data['title']        = 'Print Data Cash Out';
      $data['isi']          = 'cashout/Cashout_print';
      $data['datacash']     = $this->Cashout_model->ViewGetcashOut()->result();
      $this->load->view('cashout/Cashout_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Cashout_model');
      $data['title']        = 'Ecxport Data Cash Out';
      $data['isi']          = 'cashin/Cashout_export';
      $data['filenm']       = 'cashout-class';
      $data['datacash']     = $this->Cashout_model->ViewGetcashOut()->result();
      $this->load->view('cashout/Cashout_export',$data);
    }
    else if (trim($uri) == "delete") {

      //post file
      $cashoutid     = $_POST['cashoutid'];

        $this->db->query("UPDATE  m_cashout 
                          SET     isactive        = 'N',
                                  lastupdatedate  = '".$datetm."',
                                  lastupdateby    = '".$usernm."' 
                          WHERE   cashoutid       = '".$cashoutid."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else{
      $this->load->model('Cashout_model');
      $data['title']        = 'Data Cash Out';
      $data['isi']          = 'cashout/Cashout_view';
      $data['datacash']     = $this->Cashout_model->ViewGetcashOut()->result();
      $this->load->view('cashout/Cashout_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}