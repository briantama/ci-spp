<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportpayspp extends CI_Controller {

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


	//deposit
	function viewReportpayspp(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if (trim($uri) == "search") {

      //post file
      $schoolx       = (trim($_POST['periodyear']) != "") ? "AND x.schoolyear = '".$_POST['periodyear']."'" : "";
      $studentx      = (trim($_POST['studentid']) != "") ? "AND x.studentid >= '".$_POST['studentid']."'" : "";
			$pymid         = (trim($_POST['paymentid']) != "") ? "AND x.paymentid <= '".$_POST['paymentid']."'" : "";
      $classid       = (trim($_POST['classid']) != "") ? "AND y.classid = '".$_POST['classid']."'" : "";
			//$statustype    = (trim($_POST['statustype']) != "All") ? "AND A.IsActive = '".$_POST['statustype']."'" : "";

      $qry = $this->db->query("
															  SELECT  a.monthid, a.monthname, b.paymentid, b.schoolyear, b.studentid, b.totalpaid, b.lastupdateby, b.classid,
                                        b.studentname, b.costspp
                                FROM    m_mastermonth a
                                INNER   JOIN
                                          (
                                            SELECT  x.studentid, x.schoolyear, x.paymentid, x.totalpaid, x.isactive, x.monthid, 
                                                    x.lastupdateby, y.classid, y.studentname, x.costspp
                                            FROM    m_paymentspp x
                                            INNER   JOIN m_student y on x.studentid=y.studentid and x.schoolyear=y.schoolyear
                                            INNER   JOIN m_class v on y.classid=v.classid
                                            WHERE   x.studentid <> ''
                                                    ".$schoolx."
                                                    ".$studentx."
                                                    ".$pymid."
                                                    ".$classid."
                                          )
                                          b on a.monthid=b.monthid and b.isactive ='Y'
                                WHERE   a.isactive='Y'
                                ORDER   BY b.studentid, a.monthid
																		 
														");
						
      
       if ($qry->num_rows() > 0) {
        $str = $qry->result();
        $data["Period"]    = $_POST['periodyear'];
        $data["keys"]      = $str;
 


        $jeson['status']   = "ok";
        $jeson['id']       = $schoolx;
        $jeson['msg']      = "Successfuly";
        $jeson['content']  = $this->load->view('reportpayspp/Reportpayspp_search', $data, TRUE);
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;

      }
      else{
        $str = "";
        //$this->jcode($str);
        $jeson['status']   = "failed";
        $jeson['id']       = $schoolx;
        $jeson['msg']      = "Record Not Found";
        $jeson['content']  = $str;
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;
      }
			
    }
    else if(trim($uri) == "searchstudent"){
        $varbl =  $jdeco->query;
        $prd   =  $jdeco->priod;
        if(trim($varbl))
        {
          $query = $this->db->query(" 

                                  SELECT  studentid, classid, studentname
                                  FROM    m_student
                                  WHERE   isactive ='Y'
                                          AND schoolyear = '".$prd."' 
                                          AND (studentid like '%".$varbl."%' OR studentname like '%".$varbl."%')
                                  
                                ");
           if ($query->num_rows() > 0) {
            $arr = $query->result();
            foreach($arr as $key){
              $data[] = ["student" => $key->studentid." - ".$key->studentname, "keystudent" => $key->studentid, "studentname" => $key->studentname];
            }
           }
           else{
            $data = array();
           }

           $this->jcode($data);
           exit;
        }
        else
        {
           $data = array();
           $this->jcode($data);
           exit;
        }

    }
		else if(trim($uri) == "searchclass"){
        $varbl =  $jdeco->querycl;
        if(trim($varbl))
        {
          $query = $this->db->query(" 

                                    SELECT   classid, classname, description, isActive
																		FROM     m_class
																		WHERE    isactive ='Y'
																						 AND (classid LIKE '%".$varbl."%' OR classname LIKE '%".$varbl."%')
                                ");
           if ($query->num_rows() > 0) {
            $arr = $query->result();
            foreach($arr as $key){
              $data[] = ["classid" => $key->classid." - ".$key->classname, "keyclassid" => $key->classid, "classname" => $key->classname];
            }
           }
           else{
            $data = array();
           }

           $this->jcode($data);
           exit;
        }
        else
        {
           $data = array();
           $this->jcode($data);
           exit;
        }

    }
    else if(trim($uri) == "viewperiod"){
       
          $query = $this->db->query(" 

                                    SELECT   schoolyear, description
                                    FROM     m_schoolyear
                                    WHERE    isactive ='Y'
                                ");
           if ($query->num_rows() > 0) {
            $arr = $query->result();
            foreach($arr as $key){
              $data[] = ["schoolyear" => $key->schoolyear];
            }
           }
           else{
            $data = array();
           }

           $this->jcode($data);
           exit;
    }
    else if(trim($uri) == "print"){
      $this->load->model('Reportpayspp_model');
      $data['title']        = 'Print Report Payment SPP';
      $data['isi']          = 'reportpayspp/Reportpayspp_print';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["Period"]       = $_GET['Period'];
      $this->load->view('reportpayspp/Reportpayspp_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Reportpayspp_model');
      $data['title']        = 'Export Report Payment SPP';
      $data['isi']          = 'reportpayspp/Reportpayspp_export';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["Period"]       = $_GET['Period'];
      $data["filenm"]       = "report-payment-spp";
      $this->load->view('reportpayspp/Reportpayspp_export',$data);
    }
    else{
      $this->load->model('Reportpayspp_model');
      $data['title']        = 'Report Payment SPP';
      $data['isi']          = 'reportpayspp/Reportpayspp_view';
      $data['rptwdh']      = $this->Reportpayspp_model->ViewGetReportpayspp()->result();
      $this->load->view('reportpayspp/Reportpayspp_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}