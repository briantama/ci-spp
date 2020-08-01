<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportcashin extends CI_Controller {

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


	//deposit
	function viewReportCashIn(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if (trim($uri) == "search") {

      //post file
      $startdate     = (trim($_POST['startdate']) != "") ? "AND cashdate >= '".$_POST['startdate']."'" : "";
			$enddate       = (trim($_POST['enddate']) != "") ? "AND cashdate <= '".$_POST['enddate']."'" : "";
      $cashid        = (trim($_POST['cashid']) != "") ? "AND cashinid = '".$_POST['cashid']."'" : "";
			$statustype    = (trim($_POST['statustype']) != "All") ? "AND isactive = '".$_POST['statustype']."'" : "";

      $qry = $this->db->query("

															SELECT  cashinid, cashdate, cashamount, description,
                                      isactive, entryby, entrydate, lastupdateby, lastupdatedate
                              FROM    m_cashin
                              WHERE   cashinid <> ''
                                      ".$startdate."
                                      ".$enddate."
                                      ".$cashid."
                                      ".$statustype."
                              ORDER BY cashinid, cashdate
																		 
														");
						
      
       if ($qry->num_rows() > 0) {
        $str = $qry->result();
        $data["StartDate"] = (trim($_POST['startdate']) != "") ? $_POST['startdate'] : date('Y-m-d');
        $data["EndDate"]   = (trim($_POST['enddate']) != "") ? $_POST['enddate'] : date('Y-m-d');
        $data["keys"]      = $str;
 


        $jeson['status']   = "ok";
        $jeson['id']       = $cashid;
        $jeson['msg']      = "Successfuly";
        $jeson['content']  = $this->load->view('reportcashin/Reportcashin_search', $data, TRUE);
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;

      }
      else{
        $str = "";
        //$this->jcode($str);
        $jeson['status']   = "failed";
        $jeson['id']       = $cashid;
        $jeson['msg']      = "Record Not Found";
        $jeson['content']  = $str;
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;
      }
			
    }
    else if(trim($uri) == "print"){
      $this->load->model('Reportcashin_model');
      $data['title']        = 'Print Report Cash In';
      $data['isi']          = 'reportcashin/Reportcashin_print';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $this->load->view('reportcashin/Reportcashin_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Reportcashin_model');
      $data['title']        = 'Print Report Cash In';
      $data['isi']          = 'reportcashin/Reportcashin_export';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $data["filenm"]       = "report-cashin";
      $this->load->view('reportcashin/Reportcashin_export',$data);
    }
    else{
      $this->load->model('Reportcashin_model');
      $data['title']        = 'Report Cash In';
      $data['isi']          = 'reportcashin/Reportcashin_view';
      $data['rptcashin']    = $this->Reportcashin_model->ViewGetReportCashIn()->result();
      $this->load->view('reportcashin/Reportcashin_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}