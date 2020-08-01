<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setupprint extends CI_Controller {

  function __construct(){
    parent::__construct();
  
    if($this->session->userdata('status') != "login"){
      redirect(base_url("login"));
    }
  }

  public function index() {
    $data=array('title'=>'Bryn Store - Halaman Administrator',
                'isi' =>'dasbor/dasbor_view'
                  );
    $this->load->view('layout/wrapper',$data);  
  }


  public function viewSetupPrint() {

    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
   
    //get library
    $datetm     = date('Y-m-d H:i:s');
    $usernm     = $this->session->userdata('nama');


    if(trim($uri) == "view"){
      $qry = $this->db->query("SELECT * FROM m_setupprint");
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
    else if (trim($uri) == "save") {
      $status    = "";
      $msg       = "";
      $file_element_name = 'file';

      //code post 
      $stpidx       = $_POST["setupid"];
      $stpheader    = $_POST["setuphead"];
      $stpfooter    = $_POST["setupfoot"];
      $stpshow      = $_POST["setupimg"];
     

      if ($status != "error") {
        $config['upload_path']   = './upload/print/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
          $status = 'ok';
          $msg = $this->upload->display_errors('', '');


          $res = $this->db->query("SELECT setupprintid FROM m_setupprint WHERE setupprintid = '".$stpidx."'");
          if ($res->num_rows() > 0) {

              $this->db->query("UPDATE  m_setupprint
                                      SET     setupheader             = '".$stpheader."',
                                              setupfooter             = '".$stpfooter."',
                                              setupimageshow          = '".$stpshow."',
                                              IsActive                = 'Y',
                                              lastupdatedate          = '".$datetm."',
                                              lastupdateby            = '".$usernm."'
                                      WHERE   setupprintid            = '".$stpidx."'
                              ");
          } 
          else {

            //notif save error uload image null
            $jeson['status']   = "failed";
            $jeson['msg']      = "Print Image, ".$msg;
            $jeson['focus']    = "photo";
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

          $ambil_gambar = $this->db->query("SELECT setupimage, setupprintid FROM m_setupprint WHERE setupprintid = '".$stpidx."'");
          if ($ambil_gambar->num_rows() > 0) {

            $rowf = $ambil_gambar->row();
            if(trim($rowf->setupimage) != ""){
              if(file_exists("./upload/print/".$rowf->setupimage)){
                unlink("./upload/print/".$rowf->setupimage);
              }
            }
            

            $this->db->query("UPDATE  m_setupprint
                                      SET     setupimage              = '".$data['file_name']."', 
                                              setupheader             = '".$stpheader."',
                                              setupfooter             = '".$stpfooter."',
                                              setupimageshow          = '".$stpshow."',
                                              isactive                = 'Y',
                                              lastupdatedate          = '".$datetm."',
                                              lastupdateby            = '".$usernm."'
                                      WHERE   setupprintid           = '".$stpidx."'
                            ");
          } 
          else {
            $this->db->query("INSERT INTO m_setupprint
                                    ( setupheader, setupfooter, setupimage, setupimageshow, 
                                      isactive, entryby, entrydate, lastupdateby, lastupdatedate   ) 
                              VALUES 
                                    ('".$stpheader."', '".$stpfooter."', '".$data['file_name']."', '".$stpshow."',
                                     'Y', '".$usernm."', '".$datetm."', '".$usernm."' , '".$datetm."')  
                            ");
          }
        }
      }
      $jeson['status']   = $status;
      $jeson['id']       = $stpidx;
      $jeson['msg']      = "Print Save ".$msg;
      $jeson['notif']    = "Successfuly Saved !!!" . $msg;
      header('Content-Type: text/html');
      echo json_encode($jeson);
      exit;
    }
    else if(trim($uri) == "print"){
      $data['title']        = 'Print Bill Test';
      $data['isi']          = 'setupprint/Setupprint_print';
      $data['sldata']       = "";
      $this->load->view('setupprint/Setupprint_print',$data);
    }
    else
    {
      
      $data=array('title'=>'Setup Print',
                  'isi'  =>'setupprint/Setupprint_view' 
                );
      $this->load->view('setupprint/Setupprint_view',$data);

    }

  }

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}