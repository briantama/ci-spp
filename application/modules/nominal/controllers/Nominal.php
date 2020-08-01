<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nominal extends CI_Controller {

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
	function viewnominalPayment(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $limit = ($uri1 != "ALL") ? "LIMIT ". $uri1 : "";
      $qry   = $this->db->query("SELECT * FROM m_nominalpayment ".$limit." ");
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
    else if(trim($uri) == "searchclass"){
        $varbl =  $jdeco->query;
        if(trim($varbl))
        {
          $query = $this->db->query(" 

                                    SELECT   classid, classname, description, isactive
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
    else if (trim($uri) == "save") {

      //post file
      $classid     = htmlspecialchars($_POST['classid']);
      $period      = htmlspecialchars($_POST['periodyear']);
      $amount      = htmlspecialchars($_POST['amount']);
      $desc        = htmlspecialchars(ucwords(strtolower($_POST['desc'])));

      $res = $this->db->query("SELECT classid FROM m_nominalpayment WHERE classid = '".$classid."' AND schoolyear = '".$period."' ");
          if ($res->num_rows() == 0) {
						
            $this->db->query("INSERT INTO m_nominalpayment
																		( classid, schoolyear, nominalamount, description,
                                      isactive, entryby, entrydate, lastupdateby, lastupdatedate ) 
															VALUES 
																		( '".$classid."', '".$period."', ".$amount.", '".$desc."',
                                      'Y', '".$usernm."', '".$datetm."', '".$usernm."',  '".$datetm."')	
														");
						$msg = "Save";
          }
					else {
						$this->db->query("UPDATE 	m_nominalpayment
																			SET			nominalamount           = ".$amount.",
                                              description             = '".$desc."',
																							isactive 								= 'Y',
																							lastupdatedate      		= '".$datetm."',
																							lastupdateby        		= '".$usernm."'
																			WHERE 	classid  			          = '".$classid."'
                                      AND     schoolyear              = '".$period."'
														");
						$msg = "Update";
          }
        
      
      $jeson['status']   = "ok";
      $jeson['id']       = $classid;
      $jeson['msg']      = "Successfuly ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if(trim($uri) == "print"){
      $this->load->model('Nominal_model');
      $data['title']        = 'Print Data Nominal Payment';
      $data['isi']          = 'nominal/Nominal_print';
      $data['dataamount']   = $this->Nominal_model->ViewGetNominal()->result();
      $this->load->view('nominal/Nominal_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Nominal_model');
      $data['title']        = 'Export Data Nominal Payment';
      $data['isi']          = 'nominal/Nominal_export';
      $data['filenm']       = 'master-nominal-payment';
      $data['dataamount']    = $this->Nominal_model->ViewGetNominal()->result();
      $this->load->view('nominal/Nominal_export',$data);
    }
    else if (trim($uri) == "delete") {

      //post file
      $classid     = $_POST['classid'];

        $this->db->query("UPDATE  m_nominalpayment 
                          SET     isactive        = 'N',
                                  lastupdatedate  = '".$datetm."',
                                  lastupdateby    = '".$usernm."' 
                          WHERE   classid         = '".$classid."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else{
      $this->load->model('Nominal_model');
      $data['title']        = 'Data Nominal Payment';
      $data['isi']          = 'nominal/Nominal_view';
      $data['dataclass']    = $this->Nominal_model->ViewGetNominal()->result();
      $this->load->view('nominal/Nominal_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}