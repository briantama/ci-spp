<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportcash extends CI_Controller {

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
	function viewReportCash(){
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
      $refid         = (trim($_POST['refid']) != "") ? "AND refid = '".$_POST['refid']."'" : "";
      $admname       = (trim($_POST['adminname']) != "") ? "AND lastupdateby  LIKE '%".$_POST['statustype']."%'" : "";
			$statustype    = (trim($_POST['statustype']) != "") ? "AND isactive = '".$_POST['statustype']."'" : "";
      $reporttype    = (trim($_POST['reporttype']) != "") ? "".$_POST['reporttype']."" : "";


      if(trim($reporttype) == "DC"){
          $qry = $this->db->query("

                                  SELECT  refid, cashdate, cashamount, cashamountout, description, lastupdateby, lastupdatedate
                                  FROM    (
            															SELECT  cashinid as refid, cashdate, cashamount, 0 as cashamountout, description,
                                                  isactive, lastupdateby, lastupdatedate
                                          FROM    m_cashin
                                          WHERE   cashinid <> ''

                                          UNION ALL

                                          SELECT  cashoutid as refid, cashdate, 0 as cashamount, cashamountout, description,
                                                  isactive, lastupdateby, lastupdatedate
                                          FROM    m_cashout
                                          WHERE   cashoutid <> ''
                                          ) xz
                                  WHERE  refid <> ''
                                          ".$startdate."
                                          ".$enddate."
                                          ".$refid."
                                          ".$admname."
                                          ".$statustype."
                                  ORDER BY  cashdate, refid
    																		 
    														");
    						
          
           if ($qry->num_rows() > 0) {
            $str = $qry->result();
            $data["StartDate"] = (trim($_POST['startdate']) != "") ? $_POST['startdate'] : date('Y-m-d');
            $data["EndDate"]   = (trim($_POST['enddate']) != "") ? $_POST['enddate'] : date('Y-m-d');
            $data["keys"]      = $str;
     


            $jeson['status']   = "ok";
            $jeson['id']       = $refid;
            $jeson['msg']      = "Successfuly";
            $jeson['content']  = $this->load->view('reportcash/Reportcash_search', $data, TRUE);
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;

          }
          else{
            $str = "";
            //$this->jcode($str);
            $jeson['status']   = "failed";
            $jeson['id']       = $refid;
            $jeson['msg']      = "Record Not Found";
            $jeson['content']  = $str;
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;
          }
      }
      else
      {
          $qry = $this->db->query("

                                SELECT  SUM(COALESCE(cashamount,0)) AS cashamount, SUM(COALESCE(cashamountout,0)) AS cashamountout
                                FROM    (
                                        SELECT  SUM(cashamount) AS cashamount, 0 AS cashamountout
                                        FROM    m_cashin
                                        WHERE   cashinid <> ''
                                                and isactive = 'Y'

                                        UNION ALL

                                        SELECT  0 as cashamount, SUM(cashamountout) AS cashamountout
                                        FROM    m_cashout
                                        WHERE   cashoutid <> ''
                                                and isactive = 'Y'
                                        ) xz
                                       
                              ");
              
        
         if ($qry->num_rows() > 0) {
          $str = $qry->result();
          $data["StartDate"] = (trim($_POST['startdate']) != "") ? $_POST['startdate'] : date('Y-m-d');
          $data["EndDate"]   = (trim($_POST['enddate']) != "") ? $_POST['enddate'] : date('Y-m-d');
          $data["keys"]      = $str;
   


          $jeson['status']   = "ok";
          $jeson['id']       = $refid;
          $jeson['msg']      = "Successfuly";
          $jeson['content']  = $this->load->view('reportcash/Reportcash_searchtotal', $data, TRUE);
          header('Content-Type: text/html');
          echo json_encode($jeson);
          exit;

        }
        else{
          $str = "";
          //$this->jcode($str);
          $jeson['status']   = "failed";
          $jeson['id']       = $refid;
          $jeson['msg']      = "Record Not Found";
          $jeson['content']  = $str;
          header('Content-Type: text/html');
          echo json_encode($jeson);
          exit;
        }
      }
			
    }
     else if(trim($uri) == "printtotal"){
      $this->load->model('Reportcash_model');
      $data['title']        = 'Print Report Cash History';
      $data['isi']          = 'reportcash/Reportcash_printtotal';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $this->load->view('reportcash/Reportcash_printtotal',$data);
    }
    else if(trim($uri) == "exporttotal"){
      $this->load->model('Reportcash_model');
      $data['title']        = 'Print Report Cash History';
      $data['isi']          = 'reportcash/Reportcash_exporttotal';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $data["filenm"]       = "report-cashout";
      $this->load->view('reportcash/Reportcash_exporttotal',$data);
    }
    else if(trim($uri) == "print"){
      $this->load->model('Reportcash_model');
      $data['title']        = 'Print Report Cash History';
      $data['isi']          = 'reportcash/Reportcash_print';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $this->load->view('reportcash/Reportcash_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Reportcash_model');
      $data['title']        = 'Print Report Cash History';
      $data['isi']          = 'reportcash/Reportcash_export';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $data["filenm"]       = "report-cashout";
      $this->load->view('reportcash/Reportcash_export',$data);
    }
    else{
      $this->load->model('Reportcash_model');
      $data['title']        = 'Report Cash History';
      $data['isi']          = 'reportcash/Reportcash_view';
      $data['rptcashin']    = $this->Reportcash_model->ViewGetreportCash()->result();
      $this->load->view('reportcash/Reportcash_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}