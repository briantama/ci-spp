<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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


  public function viewProfile() {

    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
   
    //get library
    $datetm     = date('Y-m-d H:i:s');
    $usernm     = $this->session->userdata('nama');

    if (trim($uri) == "save") 
    {
     
      $status = "";
      $msg    = "";
      $file_element_name = 'file';
      if ($status != "error") {
        $config['upload_path']   = './upload/user/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_element_name)) {

          $status = 'ok';
          $msg    = $this->upload->display_errors('', '');

          
          $data = $this->upload->data();
          $image_path = $data['full_path'];
          if(file_exists($image_path)) {
            $status = "ok";
            $msg    = "Upload gambar berhasil";
          } else {
            $status = "ok";
            $msg    = "Terjadi kesalahan. Ulangi lagi.";
          }
          $ambil_gambar = $this->db->query("SELECT adminimage, username FROM m_admin WHERE username = '".$usernm."'");
          if ($usernm != "") 
          {

            if($ambil_gambar->num_rows() > 0){
              $ambil_gambar = $ambil_gambar->row();
              if($ambil_gambar->adminimage != ""){
                if(file_exists("./upload/user/".$ambil_gambar->adminimage)){
                  unlink("./upload/user/".$ambil_gambar->adminimage);
                }
              }
            }
            
            $this->db->query("UPDATE  m_admin
                                      SET     adminimage         = '".$data['file_name']."',
                                              lastupdatedate     = '".$datetm."',
                                              lastupdateby       = '".$usernm."'
                                      WHERE   username           = '".$usernm."'
                            ");
          } 
        }

      }

      $jeson['status']   = $status;
      $jeson['id']       = $usernm;
      $jeson['msg']      = "Profile Image ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!";
      $jeson['filenm']   = $data['file_name'];
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if (trim($uri) == "update") {

        //post data
        $adminid   = $_POST["idxadmin"];
        $adminnm   = $_POST["namex"];
        $email     = $_POST["emailx"];
        $dateof    = $_POST["dateofx"];


        if(trim($adminid) != ""){
      
          $this->db->query("  UPDATE  m_admin
                                  SET     adminname        = '".$adminnm."',
                                          dateofbirth      = '".$dateof."',
                                          email            = '".$email."'
                                  WHERE   adminid          = ".$adminid."
                                    
                      ");
              $msg = "Update";
            

            $jeson['status']   = "ok";
            $jeson['id']       = $adminid;
            $jeson['msg']      = "User Successfuly ".$msg;
            $jeson['notif']    = "Successfuly Saved !!!";
            header('Content-Type: text/html');
            echo json_encode($jeson);
            exit;

        }
        else{

          $jeson['status']   = "ok";
          $jeson['id']       = $adminid;
          $jeson['msg']      = "Failed Update Data adminid Not Found";
          $jeson['notif']    = "Failed Update Data !!!";
          header('Content-Type: text/html');
          echo json_encode($jeson);
          exit;

        }
            
        
    }
    //show data profile
    else if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM m_admin WHERE username = '".$usernm."'");
      if ($qry->num_rows() > 0) {
        $res = $qry->result();
        $this->jcode($res);
      }
      else{
        $str = "";
        $this->jcode($str);
      }
      exit();
    }
    else
    {
      $usernm     = $this->session->userdata('nama');
      $where = array(
        'username' => $usernm
        );
      $this->load->model('Profile_model');
      $data=array('title'=>'Data Profile',
                  'isi'  =>'profile/Profile_view' 
                );
      $data['dataAdmin'] = $this->Profile_model->getAdmin($where, "m_admin")->result();  
      $this->load->view('profile/Profile_view',$data);

    }

  }

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}