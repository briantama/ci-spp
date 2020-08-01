<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setupprofile extends CI_Controller {

	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index() {
		$data=array('title'=>'Apps Bryn- Halaman Administrator',
      					 'isi' =>'dasbor/dasbor_view'
      						);
		$this->load->view('layout/wrapper',$data);	
	}


	//galeri widget
	function viewSetupprofile(){
    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM m_setupprofile");
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
    else if (trim($uri) == "save") {
      $status = "";
      $msg    = "";
      $file_element_name = 'file';

      //post file
      $stpid       = $_POST['stpid'];
      $stptl       = $_POST['stptitle'];
      $stpnm       = $_POST['stpname'];
      $stpdc       = ucwords(strtolower($_POST['stpdesc']));
      $stpimg      = $_POST['stpimg'];

      if ($status != "error") {
        $config['upload_path']   = './upload/profile/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
          $status = 'ok';
          $msg = $this->upload->display_errors('', '');

          $cek = $this->db->query("SELECT setupprofileid FROM m_setupprofile WHERE setupprofileid = ".$_POST['stpid']."");
          if ($cek->num_rows() > 0) {
            $this->db->query("UPDATE  m_setupprofile
                                      SET     setuptitle              = '".$stptl."',
                                              setupname               = '".$stpnm."',
                                              setupdescription        = '".$stpdc."',
                                              setupimagedasbor        = '".$stpimg."',
                                              isactive                = 'Y',
                                              lastupdatedate          = '".$datetm."',
                                              lastupdateby            = '".$usernm."'
                                      WHERE   setupprofileid          =  ".$stpid."
                              ");
            
          } 
          else {

            //notif save error uload image null
            $jeson['status']   = "failed";
            $jeson['msg']      = "failed save, ".$msg;
            $jeson['focus']    = "file";
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;

          }
        } 
        else {
          $data = $this->upload->data();
          $image_path = $data['full_path'];
          if(file_exists($image_path)) {
            $status = "ok";
            $msg    = "Upload gambar berhasil";
          } else {
            $status = "ok";
            $msg    = "Terjadi kesalahan. Ulangi lagi.";
          }
          $ambil_gambar = $this->db->query("SELECT setupimage, setupprofileid FROM m_setupprofile WHERE setupprofileid = ".$_POST['stpid']."");
          if ($ambil_gambar->num_rows() > 0) {
            $ambil_gambar = $ambil_gambar->row();
            if($ambil_gambar->setupimage != ""){
              if(file_exists("./upload/profile/".$ambil_gambar->setupimage)){
                unlink("./upload/profile/".$ambil_gambar->setupimage);
              }
            }

            $this->db->query("
                                UPDATE  m_setupprofile
                                      SET     setupimage              = '".$data['file_name']."', 
                                              setuptitle              = '".$stptl."',
                                              setupname               = '".$stpnm."',
                                              setupdescription        = '".$stpdc."',
                                              setupimagedasbor        = '".$stpimg."',
                                              isactive                = 'Y',
                                              lastupdatedate          = '".$datetm."',
                                              lastupdateby            = '".$usernm."'
                                      WHERE   setupprofileid          = ".$stpid."
                            ");

          } 
          else 
          {
               $this->db->query("INSERT INTO m_setupprofile
                                    ( setuptitle, setupname, setupdescription, setupimagedasbor, setupimage, 
                                      isactive, EntryBy, EntryDate, lastupdateby, lastupdatedate ) 
                              VALUES 
                                    ( '".$stptl."', '".$stpnm."', '".$stpdc."',  '".$stpimg."', '".$data['file_name']."', 
                                      'Y', '".$usernm."', '".$datetm."', '".$usernm."',  '".$datetm."') 
                            ");
      
          }
        }
      }
      $jeson['status']   = $status;
      $jeson['id']       = $stpid;
      $jeson['msg']      = "Setup Profile Save ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
   
    else{
      $this->load->model('Setupprofile_model');
      $data['title']        = 'Data Setupprofile';
      $data['isi']          = 'setupprofile/Setupprofile_view';
      $data['datastp']      = $this->Setupprofile_model->ViewGetSetupprofile()->result();
      $this->load->view('setupprofile/Setupprofile_view',$data);
    }
	}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}