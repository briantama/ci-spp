<?php

  $img   = "default.jpeg";
  $stpnm = "Aplikasi Payment SPP Bryn";
  $query = $this->db->query(" SELECT setupimagelogo, setupname
                              FROM   m_setupprofile
                            ");
  if ($query->num_rows() > 0) {
      $arr   = $query->row();
      $img   = (trim($arr->setupimagelogo) != "") ? $arr->setupimagelogo : "default.jpeg";
      $stpnm = $arr->setupname;
  }

  $image = "./upload/logo/".$img;

  if(file_exists($image)){
      $image = base_url()."upload/logo/".$img;
    }
    else{
      $image = base_url()."upload/logo/default.jpeg";
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $stpnm; ?></title>
  <link rel="shortcut icon" href="<?php echo $image; ?>">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/js/bootstrap-datepicker.min.css">
  
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/jqvmap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/weather-icons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/weather-icons-wind.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/summernote-bs4.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/css/components.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/css/animate.css">

  <!-- new jquery -->
  <script src="<?php echo base_url(); ?>/stisla-master/assets/js/jquery-1.11.3.min.js"></script>
</head>

<style type="text/css">
  .shownotifmsg {
    position:fixed;
    bottom:70%;
    right:2px;
    float:right;
    z-index:103;
  }
</style>

<body>