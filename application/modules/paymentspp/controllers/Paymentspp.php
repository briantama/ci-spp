<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paymentspp extends CI_Controller {

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
	function viewPaymentspp(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $uri3  = $this->uri->segment(6);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if (trim($uri) == "search") {

      //post file
      $period     = (trim($_POST['periodyear']) != "") ? "AND a.schoolyear ='".$_POST['periodyear']."'" : "";
      $student    = (trim($_POST['studentid']) != "") ? "AND a.studentid = '".$_POST['studentid']."'" : "";
		

      $qry = $this->db->query("
															
															SELECT  a.studentid, a.classid, a.studentname, a.gender, a.dateofbirth, a.email, 
                                      a.adress, a.joindate, a.schoolyear, a.isactive, b.classname, d.nominalamount,
                                      a.studentimage
                              FROM    m_student a 
                              INNER   JOIN m_class b on a.classid=b.classid
                              INNER   JOIN m_schoolyear c on a.schoolyear=c.schoolyear
                              INNER   JOIN m_nominalpayment d on a.classid=d.classid and a.schoolyear=d.schoolyear
                              WHERE   a.isactive ='Y'
                                      ".$period."
                                      ".$student."
																		 
														");
						
      
       if ($qry->num_rows() > 0) {
        $str = $qry->result();
        $data["Period"]    = $_POST['periodyear'];
        $data["Student"]   = $_POST['studentid'];
        $data["keys"]      = $str;
 


        $jeson['status']   = "ok";
        $jeson['id']       = $student;
        $jeson['msg']      = "Successfuly";
        $jeson['content']  = $this->load->view('paymentspp/paymentspp_search', $data, TRUE);
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;

      }
      else{
        $str = "";
        //$this->jcode($str);
        $jeson['status']   = "failed";
        $jeson['id']       = $student;
        $jeson['msg']      = "Record Not Found";
        $jeson['content']  = $str;
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;
      }
			
    }
    else if (trim($uri) == "searchx") {

      //post file
      $period     = (trim($_POST['periodyear']) != "") ? "AND a.schoolyear ='".$_POST['periodyear']."'" : "";
      $student    = (trim($_POST['studentid']) != "") ? "AND a.studentid = '".$_POST['studentid']."'" : "";
    

      $qry = $this->db->query("
                              
                              SELECT  a.studentid, a.classid, a.studentname, a.gender, a.dateofbirth, a.email, 
                                      a.adress, a.joindate, a.schoolyear, a.isactive, b.classname, d.nominalamount
                              FROM    m_student a 
                              INNER   JOIN m_class b on a.classid=b.classid
                              INNER   JOIN m_schoolyear c on a.schoolyear=c.schoolyear
                              INNER   JOIN m_nominalpayment d on a.classid=d.classid
                              WHERE   a.isactive ='Y'
                                      ".$period."
                                      ".$student."
                                     
                            ");
            
      
       if ($qry->num_rows() > 0) {
        $str = $qry->result();
      

        $jeson['status']   = "ok";
        $jeson['id']       = $student;
        $jeson['msg']      = "Successfuly";
        $jeson['content']  = $str;
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;

      }
      else{
        $str = "";
        //$this->jcode($str);
        $jeson['status']   = "failed";
        $jeson['id']       = $student;
        $jeson['msg']      = "Record Not Found";
        $jeson['content']  = $str;
        header('Content-Type: text/html');
        echo json_encode($jeson);
        exit;
      }
      
    }
     else if(trim($uri) == "searchcard"){
        $schoolx     = $uri2;
        $studentx    = $uri1;

        if(trim($schoolx)  != "" && trim($studentx) != "")
        {
          $query = $this->db->query(" 

                                SELECT  a.monthid, a.monthname, b.paymentid, b.schoolyear, b.studentid, b.totalpaid, b.lastupdateby 
                                FROM    m_mastermonth a
                                LEFT    JOIN
                                          (
                                            SELECT  x.studentid, x.schoolyear, x.paymentid, x.totalpaid, x.isactive, x.monthid, x.lastupdateby
                                            FROM    m_paymentspp x
                                            INNER   JOIN m_student y on x.studentid=y.studentid and x.schoolyear=y.schoolyear
                                            WHERE   x.schoolyear = '".$schoolx."'
                                                    AND x.studentid = '".$studentx."' 
                                          )
                                          b on a.monthid=b.monthid and b.isactive ='Y'
                                WHERE   a.isactive='Y'
                                ORDER   BY a.monthid
                                  
                                ");
           if ($query->num_rows() > 0) {
            $data = $query->result();
           }
           else{
            $data = array();
           }

           $this->jcode($data);
           exit;
        }
        else
        {
           $data = "";
           $this->jcode($data);
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
    else if (trim($uri) == "save") {

      $datx     = date('Ym'); 
      $paymentid= $_POST['monthid'];
      $query    = $this->db->query("
                                    SELECT  CONCAT('SPP-".$datx."-',LPAD(CAST(CAST(COALESCE(MAX(RIGHT(paymentid, 6)), '000000') AS INTEGER) + 1 as integer)::text, 6,'0')) as getid 
                                    FROM    m_paymentspp
                                  ");
       if ($query->num_rows() > 0) {
         $arr       = $query->first_row();
         $paymentid = $arr->getid;
         //echo $doc;
       }
      $paydate   = date('Y-m-d'); 

      //post file
      $monthid   = ucwords(strtolower($_POST['monthid']));
      $student   = ucwords(strtolower($_POST['studenx']));
      $scyear    = ucwords(strtolower($_POST['schoolyear']));
      $costspp   = ucwords(strtolower($_POST['costspp']));
      $paytype   = ucwords(strtolower($_POST['paytype']));
      $totpay    = ucwords(strtolower($_POST['totpay']));

      $res = $this->db->query(" SELECT  monthid, studentid, schoolyear 
                                FROM    m_paymentspp 
                                WHERE   monthid  = '".$monthid."' 
                                        AND studentid  = '".$student."' 
                                        AND schoolyear  = '".$scyear."'
                              ");
          if ($res->num_rows() == 0) {
            
            $this->db->query("INSERT INTO m_paymentspp
                                    ( paymentid, studentid, schoolyear, monthid, paymentdate, paymenttype, totalpaid, costspp, 
                                      isactive, entrydate, entryby, lastupdatedate, lastupdateby ) 
                              VALUES 
                                    ('".$paymentid."', '".$student."', '".$scyear."', ".$monthid.", '".$paydate."', '".$paytype."', ".$totpay.", ".$costspp.",
                                     'Y', '".$datetm."', '".$usernm."',  '".$datetm."', '".$usernm."')  
                            ");
            $msg = "Save";
          }
          else {
            $this->db->query("UPDATE  m_paymentspp
                                      SET     paymenttype             = '".$paytype."',
                                              paymentid               = '".$paymentid."',
                                              totalpaid               = ".$totpay.",
                                              costspp                 = ".$costspp.",
                                              isactive                = 'Y',
                                              lastupdatedate          = '".$datetm."',
                                              lastupdateby            = '".$usernm."'
                                      WHERE   monthid                 = '".$monthid."' 
                                              AND studentid           = '".$student."' 
                                              AND schoolyear          = '".$scyear."'
                            ");
            $msg = "Update";
          }




       //load ulang paymet spp
       $period     = (trim($scyear) != "") ? "AND a.schoolyear ='".$scyear."'" : "";
       $studenx    = (trim($student) != "") ? "AND a.studentid = '".$student."'" : "";
       $qry = $this->db->query("
                              
                              SELECT  a.studentid, a.classid, a.studentname, a.gender, a.dateofbirth, a.email, 
                                      a.adress, a.joindate, a.schoolyear, a.isactive, b.classname, d.nominalamount,
                                      a.studentimage
                              FROM    m_student a 
                              INNER   JOIN m_class b on a.classid=b.classid
                              INNER   JOIN m_schoolyear c on a.schoolyear=c.schoolyear
                              INNER   JOIN m_nominalpayment d on a.classid=d.classid and a.schoolyear=d.schoolyear
                              WHERE   a.isactive ='Y'
                                      ".$period."
                                      ".$studenx."
                                     
                            ");
            
      
       if ($qry->num_rows() > 0) {
        $str = $qry->result();
        $data["Period"]    = $scyear;
        $data["Student"]   = $student;
        $data["keys"]      = $str;
        $content           = $this->load->view('paymentspp/paymentspp_searchload', $data, TRUE);

      }
      else{
        $str               = "";
        $content           = $str;
      
      }
        
      
      $jeson['status']   = "ok";
      $jeson['id']       = $student;
      $jeson['msg']      = "Successfuly ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      $jeson['content']  = $content;
      // header('Content-Type: text/html');
      // echo jcode($jeson);
      $this->jcode($jeson);
      exit();
    }
    else if (trim($uri) == "savemulti") {

      $datx     = date('Ym'); 
      $paymentid= $_POST['monthidmx'];
      $query    = $this->db->query("
                                    SELECT  CONCAT('SPP-".$datx."-',LPAD(CAST(CAST(COALESCE(MAX(RIGHT(paymentid, 6)), '000000') AS INTEGER) + 1 as integer)::text, 6,'0')) as getid 
                                    FROM    m_paymentspp
                                  ");
       if ($query->num_rows() > 0) {
         $arr       = $query->first_row();
         $paymentid = $arr->getid;
         //echo $doc;
       }
      $paydate   = date('Y-m-d'); 

      //post file
      $monthid   = ucwords(strtolower($_POST['monthidmx']));
      $emonthid  = ucwords(strtolower($_POST['emonthidmx']));
      $student   = ucwords(strtolower($_POST['studenmx']));
      $scyear    = ucwords(strtolower($_POST['schoolyearmx']));
      $costspp   = ucwords(strtolower($_POST['costsppmx']));
      $paytype   = ucwords(strtolower($_POST['paytypemx']));
      $totpay    = ucwords(strtolower($_POST['totpaymx']));

      $total = 0;
      $tot   = 0;
      for ($x = $monthid; $x <= $emonthid; $x++) {

        $res = $this->db->query(" SELECT  monthid, studentid, schoolyear 
                                  FROM    m_paymentspp 
                                  WHERE   monthid  = '".$x."' 
                                          AND studentid  = '".$student."' 
                                          AND schoolyear  = '".$scyear."'
                                ");
            if ($res->num_rows() == 0) {
                $tot = $total++;
            }
            else{
                $jeson['status']   = "failed";
                $jeson['id']       = $student;
                $jeson['msg']      = "Failed To Saved. Payment SPP Month ". $this->getMonthname($x) .$scyear." Already Payment";
                $jeson['notif']    = "Failed Saved !!!";
                $jeson['content']  = "";
                // header('Content-Type: text/html');
                // echo jcode($jeson);
                $this->jcode($jeson);
                exit();
            }

      }

      if($tot > 0){

        for ($x = $monthid; $x <= $emonthid; $x++) {

          $res = $this->db->query(" SELECT  monthid, studentid, schoolyear 
                                    FROM    m_paymentspp 
                                    WHERE   monthid  = '".$x."' 
                                            AND studentid  = '".$student."' 
                                            AND schoolyear  = '".$scyear."'
                                  ");
              if ($res->num_rows() == 0) {
                
                $this->db->query("INSERT INTO m_paymentspp
                                        ( paymentid, studentid, schoolyear, monthid, paymentdate, paymenttype, totalpaid, costspp, 
                                          isactive, entrydate, entryby, lastupdatedate, lastupdateby ) 
                                  VALUES 
                                        ('".$paymentid."', '".$student."', '".$scyear."', ".$x.", '".$paydate."', '".$paytype."', ".$totpay.", ".$costspp.",
                                         'Y', '".$datetm."', '".$usernm."',  '".$datetm."', '".$usernm."')  
                                ");
                $msg = "Successfuly Save";
              }

              $status ="ok";
        }
      }
      else
      {
          $status = "failed";
          $msg    = "Failed Save Payment SPP Not Found";
      }
         




       //load ulang paymet spp
       $period     = (trim($scyear) != "") ? "AND a.schoolyear ='".$scyear."'" : "";
       $studenx    = (trim($student) != "") ? "AND a.studentid = '".$student."'" : "";
       $qry = $this->db->query("
                              
                              SELECT  a.studentid, a.classid, a.studentname, a.gender, a.dateofbirth, a.email, 
                                      a.adress, a.joindate, a.schoolyear, a.isactive, b.classname, d.nominalamount,
                                      a.studentimage
                              FROM    m_student a 
                              INNER   JOIN m_class b on a.classid=b.classid
                              INNER   JOIN m_schoolyear c on a.schoolyear=c.schoolyear
                              INNER   JOIN m_nominalpayment d on a.classid=d.classid and a.schoolyear=d.schoolyear
                              WHERE   a.isactive ='Y'
                                      ".$period."
                                      ".$studenx."
                                     
                            ");
            
      
       if ($qry->num_rows() > 0) {
        $str = $qry->result();
        $data["Period"]    = $scyear;
        $data["Student"]   = $student;
        $data["keys"]      = $str;
        $content           = $this->load->view('paymentspp/paymentspp_searchload', $data, TRUE);
      }
      else{
        $str               = "";
        $content           = $str;
      
      }
        
      
      $jeson['status']   = $status;
      $jeson['id']       = $student;
      $jeson['msg']      = $msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      $jeson['content']  = $content;
      // header('Content-Type: text/html');
      // echo jcode($jeson);
      $this->jcode($jeson);
      exit();
    }
    else if (trim($uri) == "delete") {
      if(trim($uri1) != "" && trim($uri2) != "" && trim($uri3) != "" ){
        $this->db->query("
                          UPDATE  m_paymentspp 
                          SET     isactive        = 'N',
                                  lastupdatedate  = '".$datetm."',
                                  lastupdateby    = '".$usernm."' 
                          WHERE   monthid  = '".$uri2."' 
                                  AND studentid  = '".$uri1."' 
                                  AND schoolyear  = '".$uri3."'
                        ");

        //load ulang paymet spp
         $period     = (trim($uri3) != "") ? "AND a.schoolyear ='".$uri3."'" : "";
         $studenx    = (trim($uri1) != "") ? "AND a.studentid = '".$uri1."'" : "";
         $qry = $this->db->query("
                                
                                SELECT  a.studentid, a.classid, a.studentname, a.gender, a.dateofbirth, a.email, 
                                        a.adress, a.joindate, a.schoolyear, a.isactive, b.classname, d.nominalamount
                                FROM    m_student a 
                                INNER   JOIN m_class b on a.classid=b.classid
                                INNER   JOIN m_schoolyear c on a.schoolyear=c.schoolyear
                                INNER   JOIN m_nominalpayment d on a.classid=d.classid and a.schoolyear=d.schoolyear
                                WHERE   a.isactive ='Y'
                                        ".$period."
                                        ".$studenx."
                                       
                              ");
              
        
         if ($qry->num_rows() > 0) {
          $str = $qry->result();
          $data["Period"]    = $uri3;
          $data["Student"]   = $uri1;
          $data["keys"]      = $str;
          $content           = $this->load->view('paymentspp/paymentspp_searchload', $data, TRUE);

        }
        else{
          $str               = "";
          $content           = $str;
        
        }

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $ret_arr['content'] = $content;
        $this->jcode($ret_arr);
        exit();
      }
      else{
        $ret_arr['status']  = "failed";
        $ret_arr['caption'] = "Failed To Delete Data";
        $this->jcode($ret_arr);
        exit();
      }
    }
    else if(trim($uri) == "printbill"){

      $qry = $this->db->query(" 
                                SELECT  x.studentid, x.schoolyear, x.paymentid, x.totalpaid, x.isactive, x.monthid, 
                                                    x.lastupdateby, x.lastupdatedate, x.costspp, x.totalpaid, x.paymentdate,
                                                    v.monthname, x.paymenttype
                                            FROM    m_paymentspp x
                                            INNER   JOIN m_student y on x.studentid=y.studentid and x.schoolyear=y.schoolyear
                                            inner   join m_mastermonth v on x.monthid=v.monthid
                                            WHERE   x.schoolyear = '".$uri1."'
                                                    AND x.studentid = '".$uri2."'
                                                    AND x.monthid = ".$uri3."
                            ");
      if ($qry->num_rows() > 0) {
        $res = $qry->result();
      }
      else
      {
        $res  = "";
      }


      $data['title']        = 'Print Bill Data Payment SPP';
      $data['isi']          = 'paymentspp/Paymentspp_printbill';
      $data['sldata']       = $res;
      $this->load->view('paymentspp/Paymentspp_printbill',$data);
    }
    else if(trim($uri) == "printcard"){
      $this->load->model('Paymentspp_model');
      $data['title']        = 'Print Card SPP';
      $data['isi']          = 'paymentspp/Paymentspp_printcard';
      $data['scyear']       = $uri2; 
      $data['studenx']      = $uri1; 
      $data['dataspp']      = $this->Paymentspp_model->ViewGetCardSPP($uri2, $uri1)->result();
      $this->load->view('paymentspp/Paymentspp_printcard',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Paymentspp_model');
      $data['title']        = 'Export Report Deposit';
      $data['isi']          = 'reportdeposit/Reportdeposit_export';
      $data['keys']         = unserialize(urldecode($uri1));
      $data["StartDate"]    = $_GET['StartDate'];
      $data["EndDate"]      = $_GET['EndDate'];
      $data["filenm"]       = "report-deposit";
      $this->load->view('reportdeposit/Reportdeposit_export',$data);
    }
    else{
      $this->load->model('Paymentspp_model');
      $data['title']        = 'Payment SPP';
      $data['isi']          = 'paymentspp/Paymentspp_view';
      $data['rptdeposit']   = $this->Paymentspp_model->ViewGetSPP()->result();
      $this->load->view('paymentspp/Paymentspp_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }


  function getMonthname($var="") {
    $r_type = $var;
    switch ($r_type) {
      case "1" :
        $str = "Januari";
        break;
       case "2" :
        $str = "Febuari";
        break;
       case "3" :
        $str = "Maret";
        break;
      case "4" :
        $str = "April";
        break;
      case "5" :
        $str = "Mei";
        break;
      case "6" :
        $str = "Juni";
        break;
      case "7" :
        $str = "Juli";
        break;
      case "8" :
        $str = "Agustus";
        break;
      case "9" :
        $str = "September";
        break;
      case "10" :
        $str = "Oktober";
        break;
      case "11" :
        $str = "November";
        break;
      case "12" :
        $str = "Desember";
        break;
      default :
        $str = "";
    }
    return $str; 
  }
  

}