<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Majors extends CI_Controller {

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
	function viewMajors(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $limit = ($uri1 != "ALL") ? "LIMIT ". $uri1 : "";
      $qry   = $this->db->query("SELECT * FROM m_majors ".$limit." ");
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
      $majorid     = htmlspecialchars(trim(strtoupper($_POST['majorid'])));
      $majorname   = htmlspecialchars($_POST['majorname']);
      $desc        = htmlspecialchars(ucwords(strtolower($_POST['desc'])));

      $res = $this->db->query("SELECT majorid FROM m_majors WHERE majorid = '".trim($majorid)."'");
          if ($res->num_rows() == 0) {
						
            $this->db->query("INSERT INTO m_majors
																		(majorid, majorname, description,
                                      isactive, entryby, entrydate, lastupdateby, lastupdatedate ) 
															VALUES 
																		( '".$majorid."', '".$majorname."', '".$desc."',
                                      'Y', '".$usernm."', '".$datetm."', '".$usernm."',  '".$datetm."')	
														");
						$msg = "Save";
          }
					else {
						$this->db->query("UPDATE 	m_majors
																			SET			majorname               = '".$majorname."',
                                              description             = '".$desc."',
																							isactive 								= 'Y',
																							lastupdatedate      		= '".$datetm."',
																							lastupdateby        		= '".$usernm."'
																			WHERE 	majorid  			          = '".trim($majorid)."'
														");
						$msg = "Update";
          }
        
      
      $jeson['status']   = "ok";
      $jeson['id']       = $majorid;
      $jeson['msg']      = "Successfuly ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if(trim($uri) == "print"){
      $this->load->model('Majors_model');
      $data['title']        = 'Print Data Majors';
      $data['isi']          = 'majors/Majors_print';
      $data['datamajor']    = $this->Majors_model->ViewGetMajors()->result();
      $this->load->view('majors/Majors_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Majors_model');
      $data['title']        = 'Ecxport Data Majors';
      $data['isi']          = 'majors/Majors_export';
      $data['filenm']       = 'master-majors';
      $data['datamajor']    = $this->Majors_model->ViewGetMajors()->result();
      $this->load->view('majors/Majors_export',$data);
    }
    else if (trim($uri) == "delete") {

      //post file
      $majorid     = $_POST['majorid'];

        $this->db->query("UPDATE  m_majors 
                          SET     isactive        = 'N',
                                  lastupdatedate  = '".$datetm."',
                                  lastupdateby    = '".$usernm."' 
                          WHERE   majorid         = '".$majorid."'
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else{
      $this->load->model('Majors_model');
      $data['title']        = 'Data Majors';
      $data['isi']          = 'majors/Majors_view';
      $data['dataclass']    = $this->Majors_model->ViewGetMajors()->result();
      $this->load->view('majors/Majors_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}