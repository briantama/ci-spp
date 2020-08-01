<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportsaving extends CI_Controller {

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
	function viewReportSaving(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if (trim($uri) == "search") {

      //post file
      $depositid     = (trim($_POST['depositid']) != "") ? "AND ReferenceID ='".$_POST['depositid']."'" : "";
      $withdrawalid  = (trim($_POST['withdrawalid']) != "") ? "AND ReferenceID ='".$_POST['withdrawalid']."'" : "";
      $startdate     = (trim($_POST['startdate']) != "") ? "AND ReferenceDate >= '".$_POST['startdate']."'" : "";
			$enddate       = (trim($_POST['enddate']) != "") ? "AND ReferenceDate <= '".$_POST['enddate']."'" : "";
      $studentid     = (trim($_POST['studentid']) != "") ? "AND StudentID = '".$_POST['studentid']."'" : "";
      $classid       = (trim($_POST['classid']) != "") ? "AND ClassID = '".$_POST['classid']."'" : "";
			$statustype    = (trim($_POST['statustype']) != "All") ? "AND IsActive = '".$_POST['statustype']."'" : "";

      $qry = $this->db->query("

															SELECT   ReferenceID, ReferenceDate, StudentID, TotalDeposit, TotalWithdrawal, LastUpdateBy,
                                       StudentName, ClassID, ClassName, IsActive
                              FROM (

    															SELECT A.DepositID AS ReferenceID, A.DepositDate AS ReferenceDate, A.StudentID, A.TotalDeposit, 0 AS TotalWithdrawal,
    																		 A.LastUpdateBy, B.StudentName, C.ClassID, C.ClassName, A.IsActive
    															FROM   T_Deposit A
    															INNER  JOIN M_Student B ON A.StudentID=B.StudentID
    															INNER  JOIN M_Class C ON B.ClassID=C.ClassID
    															WHERE  B.IsActive = 'Y'

                                  UNION ALL

                                  SELECT A.WithdrawalID AS ReferenceID, A.WithdrawalDate AS ReferenceDate, A.StudentID, 0 as TotalDeposit, A.TotalWithdrawal,
                                         A.LastUpdateBy, B.StudentName, C.ClassID, C.ClassName, A.IsActive
                                  FROM   T_Withdrawal A
                                  INNER  JOIN M_Student B ON A.StudentID=B.StudentID
                                  INNER  JOIN M_Class C ON B.ClassID=C.ClassID
                                  WHERE  B.IsActive = 'Y'

                                  ) AXX
                              WHERE   ReferenceID <> ''
                                      ".$withdrawalid."
                                      ".$depositid."
                                      ".$startdate."
                                      ".$enddate."
                                      ".$studentid."
                                      ".$classid."
                                      ".$statustype."
                              ORDER BY StudentID, ReferenceDate, ReferenceID
																		 
														");
						
      
       if ($qry->num_rows() > 0) {
        $str = $qry->result();
        $data["StartDate"] = (trim($_POST['startdate']) != "") ? $_POST['startdate'] : date('Y-m-d');
        $data["EndDate"]   = (trim($_POST['enddate']) != "") ? $_POST['enddate'] : date('Y-m-d');
        $data["keys"]      = $str;
 


        $jeson['status']   = "ok";
        $jeson['id']       = $depositid;
        $jeson['msg']      = "Successfuly";
        $jeson['content']  = $this->load->view('reportsaving/Reportsaving_search', $data, TRUE);
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;

      }
      else{
        $str = "";
        //$this->jcode($str);
        $jeson['status']   = "failed";
        $jeson['id']       = $depositid;
        $jeson['msg']      = "Record Not Found";
        $jeson['content']  = $str;
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;
      }
			
    }
    else if(trim($uri) == "searchstudent"){
        $varbl =  $jdeco->query;
        if(trim($varbl))
        {
          $query = $this->db->query(" 

                                    SELECT  A.StudentID, A.StudentName, 
                                            IFNULL(SUM(B.TotalDeposit),0) -  IFNULL(SUM(B.TotalWithdrawal),0) AS DepositBalance
                                    FROM    M_Student A
                                    LEFT    JOIN (

                                              SELECT X.StudentID, IFNULL(SUM(X.TotalDeposit),0) AS TotalDeposit , 0 AS TotalWithdrawal
                                              FROM   T_Deposit X
                                              INNER  JOIN M_Student V ON X.StudentID=V.StudentID
                                              WHERE  X.IsActive ='Y'
                                              GROUP  BY X.StudentID

                                              UNION ALL 

                                              SELECT Y.StudentID,  0 AS TotalDeposit, IFNULL(SUM(Y.TotalWithdrawal),0) AS TotalWithdrawal
                                              FROM   T_Withdrawal Y 
                                              INNER  JOIN M_Student V ON Y.StudentID=V.StudentID
                                              WHERE  Y.IsActive ='Y'
                                              GROUP  BY Y.StudentID 

                                                ) B ON A.StudentID=B.StudentID

                                    WHERE   (A.StudentID LIKE '%".$varbl."%' OR A.StudentName LIKE '%".$varbl."%')
                                    GROUP   BY A.StudentID, A.StudentName
                                
                                ");
           if ($query->num_rows() > 0) {
            $arr = $query->result();
            foreach($arr as $key){
              $data[] = ["student" => $key->StudentID." - ".$key->StudentName, "keystudent" => $key->StudentID, "studentname" => $key->StudentName, "saldo" => $key->DepositBalance];
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

                                    SELECT   ClassID, ClassName, Description, IsActive
																		FROM     M_Class
																		WHERE    IsActive ='Y'
																						 AND (ClassID LIKE '%".$varbl."%' OR ClassName LIKE '%".$varbl."%')
                                ");
           if ($query->num_rows() > 0) {
            $arr = $query->result();
            foreach($arr as $key){
              $data[] = ["classid" => $key->ClassID." - ".$key->ClassName, "keyclassid" => $key->ClassID, "classname" => $key->ClassName];
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
    else if(trim($uri) == "print"){
      $this->load->model('Reportsaving_model');
      $data['title']        = 'Print Report Saving Balance';
      $data['isi']          = 'reportsaving/Reportsaving_print';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $this->load->view('reportsaving/Reportsaving_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Reportsaving_model');
      $data['title']        = 'Print Report Saving Balance';
      $data['isi']          = 'reportsaving/Reportsaving_export';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $data["filenm"]       = "report-saving-balance";
      $this->load->view('reportsaving/Reportsaving_export',$data);
    }
    else{
      $this->load->model('Reportsaving_model');
      $data['title']        = 'Report Saving Balance';
      $data['isi']          = 'reportsaving/Reportsaving_view';
      $data['rptdeposit']   = $this->Reportsaving_model->ViewGetReportSaving()->result();
      $this->load->view('reportsaving/Reportsaving_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}