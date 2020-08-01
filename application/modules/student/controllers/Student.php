<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {

	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	public function index() {
		$data=array('title'=>'Apps Payment Student - Halaman Administrator',
      					 'isi' =>'dasbor/dasbor_view'
      						);
		$this->load->view('layout/wrapper',$data);	
	}


	
	function viewStudent(){

    $uri   = $this->uri->segment(3);
    $uri1  = $this->uri->segment(4);
    $uri2  = $this->uri->segment(5);
    $jdeco = json_decode(file_get_contents('php://input'));
	 
    //get date time
    $datetm= date('Y-m-d H:i:s');
    $usernm= $this->session->userdata('nama');

    if(trim($uri) == "view"){
      $limit = ($uri1 != "ALL") ? "LIMIT ". $uri1 : "";
      $qry = $this->db->query("SELECT * FROM m_student ".$limit." ");
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

      $status = "";
      $msg    = "";
      $file_element_name = 'file';

      //post file
      $studentid   = trim($_POST['studentid']);
      $studentnm   = $_POST['studentname'];
      $classid     = trim($_POST['classid']);
      $gender      = $_POST['gender'];
      $dateof      = $_POST['dateof'];
      $email       = $_POST['email'];
      $adress      = $_POST['adress'];
      $joindate    = $_POST['joindate'];
      $periodyear  = $_POST['periodyear'];
      $majorid     = trim($_POST['majorid']);

      if ($status != "error") {
        $config['upload_path']   = './upload/student/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 1024;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($file_element_name)) {
          $status = 'ok';
          $msg = $this->upload->display_errors('', '');

      $cek = $this->db->query("SELECT studentid FROM m_student WHERE studentid = '".$studentid."' and schoolyear='".$periodyear."'  ");
      if ($cek->num_rows() > 0) {

            $this->db->query("  UPDATE  m_student
                                        SET   classid               = '".$classid."',
                                              studentname           = '".$studentnm."',
                                              gender                = '".$gender."',
                                              dateofbirth           = '".$dateof."',
                                              email                 = '".$email."',
                                              adress                = '".$adress."',
                                              joindate              = '".$joindate."',
                                              schoolyear            = '".$periodyear."',
                                              majorid               = '".$majorid."',
                                              isactive              = 'Y',
                                              lastupdatedate        = '".$datetm."',
                                              lastupdateby          = '".$usernm."'
                                      WHERE   studentid             = '".$studentid."'
                                      AND     schoolyear            = '".$periodyear."' 
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
        else
        {

          $data = $this->upload->data();
          $image_path = $data['full_path'];
          if(file_exists($image_path)) {
            $status = "ok";
            $msg    = "Upload gambar berhasil";
          } else {
            $status = "ok";
            $msg    = "Terjadi kesalahan. Ulangi lagi.";
          }
          $ambil_gambar = $this->db->query("SELECT studentimage, studentid, schoolyear FROM m_student WHERE studentid = '".$studentid."' and schoolyear='".$periodyear."' ");

          if ($ambil_gambar->num_rows() > 0) {
            $ambil_gambar = $ambil_gambar->row();
            if($ambil_gambar->studentimage != ""){
              if(file_exists("./upload/student/".$ambil_gambar->studentimage)){
                unlink("./upload/student/".$ambil_gambar->studentimage);
              }
            }
      						
                  $this->db->query("  UPDATE  m_student
                                        SET   
                                              studentimage          = '".$data['file_name']."', 
                                              classid               = '".$classid."',
                                              studentname           = '".$studentnm."',
                                              gender                = '".$gender."',
                                              dateofbirth           = '".$dateof."',
                                              email                 = '".$email."',
                                              adress                = '".$adress."',
                                              joindate              = '".$joindate."',
                                              schoolyear            = '".$periodyear."',
                                              majorid               = '".$majorid."',
                                              isactive              = 'Y',
                                              lastupdatedate        = '".$datetm."',
                                              lastupdateby          = '".$usernm."'
                                      WHERE   studentid             = '".$studentid."'
                                      AND     schoolyear            = '".$periodyear."' 
                    ");
                 
      			
          }
      		else 
      		{

             $this->db->query("INSERT INTO m_student
                        ( studentid, classid, studentname, gender, dateofbirth, email, adress, joindate, schoolyear, majorid, studentimage,
                          isactive, entryby, entrydate, lastupdateby, lastupdatedate  ) 
                    VALUES 
                        ( '".$studentid."', '".$classid."', '".$studentnm."', '".$gender."', '".$dateof."', 
                          '".$email."', '".$adress."',  '".$joindate."', '".$periodyear."', '".$majorid."', '".$data['file_name']."', 
                          'Y', '".$usernm."', '".$datetm."', '".$usernm."',  '".$datetm."') 
                    ");

      		}
        }
      }
          
    $jeson['status']   = "ok";
    $jeson['id']       = $studentid;
    $jeson['msg']      = "Successfuly ".$msg;
    $jeson['notif']    = "Successfuly Saved !!!";
    header('Content-Type: text/html');
    echo json_encode($jeson);
    exit();

        
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
    else if(trim($uri) == "searchmajor"){
        $varbl =  $jdeco->query1;
        if(trim($varbl))
        {
          $query = $this->db->query(" 

                                    SELECT   majorid, majorname, description, isactive
                                    FROM     m_majors
                                    WHERE    isactive ='Y'
                                             AND (majorid LIKE '%".$varbl."%' OR majorid LIKE '%".$varbl."%')
                                ");
           if ($query->num_rows() > 0) {
            $arr = $query->result();
            foreach($arr as $key){
              $data[] = ["majorid" => $key->majorid." - ".$key->majorname, "keymajor" => $key->majorid, "majorname" => $key->majorname];
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
      $this->load->model('Student_model');
      $data['title']        = 'Print Data Student';
      $data['isi']          = 'student/Student_print';
      $data['studentdt']    = $this->Student_model->ViewGetStudent()->result();
      $this->load->view('student/Student_print',$data);
    }
    else if(trim($uri) == "export"){
      $this->load->model('Student_model');
      $data['title']        = 'Export Data Student';
      $data['isi']          = 'student/Student_export';
      $data['filenm']       = 'master-student';
      $data['studentdt']    = $this->Student_model->ViewGetStudent()->result();
      $this->load->view('student/Student_export',$data);
    }
    else if (trim($uri) == "delete") {

      //post file
      $studentid  = $_POST['studentid'];
      $periodyear = $_POST['periodyear'];

        $this->db->query("UPDATE  m_student 
                          SET     isactive        = 'N',
                                  lastupdatedate  = '".$datetm."',
                                  lastupdateby    = '".$usernm."' 
                          WHERE   studentid       = '".$studentid."'
                          AND     schoolyear      = '".$periodyear."' 
                        ");

        $ret_arr['status']  = "ok";
        $ret_arr['caption'] = "Delete Success !!!";
        $this->jcode($ret_arr);
        exit();
    }
    else{
      $this->load->model('Student_model');
      $data['title']        = 'Data Student';
      $data['isi']          = 'student/Student_view';
      $data['studentdt']    = $this->Student_model->ViewGetStudent()->result();
      $this->load->view('student/Student_view',$data);
    }
}

  public function jcode($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  

}