  <?php

  $title  = "No Name";
  $setrv  = "SV";
  $res    = $this->db->query('
                          SELECT  setuptitle, setupimagedasbor, setupimage
                          FROM    M_Setupprofile
                          ');
  if ($res->num_rows() > 0) {
    $settl  = $res->row();
    $setrv  = substr($settl->setuptitle, 0,2);
    if($settl->setupimagedasbor == "N"){
      $title = $settl->setupimage;
    }
    else{
      if(file_exists("./upload/profile/".$settl->setupimage)){
        $imgurl = base_url()."upload/profile/".$settl->setupimage;
        $title  = '<div class="clearfix mb-2"></div>';
        $title .= "<img src='".$imgurl."' alt='logo' width='120' height='60' class='img-responsive'>";
        $title .= '<div class="clearfix mb-3"></div>';
      }
      else{
        $imgurl = base_url()."upload/profile/default.jpeg";
        $title  = '<div class="clearfix mb-2"></div>';
        $title .= "<img src='".$imgurl."' alt='logo' width='120' height='60' class='img-responsive'>";
        $title .= '<div class="clearfix mb-3"></div>';
      }
    }
  }



  //image user
    $img = "";
    $query = $this->db->query(" SELECT  adminimage 
                                FROM    m_admin
                                WHERE   UserName ='".$this->session->userdata('nama')."'
                                      ");
    if ($query->num_rows() > 0) {
      $arr = $query->first_row();
      $img = $arr->adminimage;
               //echo $doc;
    }

      $urlimg = (trim($img) == "") ? "default.jpeg" : $img;
      $locate = "./upload/user/".$urlimg;
      if(file_exists($locate)){
        $image = base_url()."upload/user/".$urlimg;
      }
      else{
        $image = base_url()."upload/user/default.jpeg";
      }
  

  ?>

  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
              <div class="search-header">
                Histories
              </div>
              <div class="search-item">
                <a href="#">How to hack NASA using CSS</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">Kodinger.com</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">#Stisla</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-header">
                Result
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="<?php echo base_url(); ?>/stisla-master/assets/img/products/product-3-50.png" alt="product">
                  oPhone S9 Limited Edition
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="<?php echo base_url(); ?>/stisla-master/assets/img/products/product-2-50.png" alt="product">
                  Drone X2 New Gen-7
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="<?php echo base_url(); ?>/stisla-master/assets/img/products/product-1-50.png" alt="product">
                  Headphone Blitz
                </a>
              </div>
              <div class="search-header">
                Projects
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-danger text-white mr-3">
                    <i class="fas fa-code"></i>
                  </div>
                  Stisla Admin Template
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-primary text-white mr-3">
                    <i class="fas fa-laptop"></i>
                  </div>
                  Create a new Homepage Design
                </a>
              </div>
            </div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          
          
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
            <img alt="image" src="<?php echo $image; ?>" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"><?php echo $this->session->userdata('nama');?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- <div class="dropdown-title">Logged in 5 min ago</div> -->
              <a onclick="callpage('profile/viewProfile', '', '');" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
             <!-- <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>-->
              <a onclick="callpage('user/viewUser', '', '');" class="dropdown-item has-icon">
                <i class="fas fa-users"></i> Users
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo base_url('login/logout'); ?>" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"><?php echo $title; ?></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="#"><?php echo $setrv; ?></a>
          </div>
          <ul class="sidebar-menu">

              <li style="cursor: pointer;" class="menu-header" onclick="callpage('dasbor', '', '');"></i> Dashboard </li>
              
               <li id="listmaster" class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-square"></i> <span>Master</span></a>
                <ul class="dropdown-menu">
                  <li id="m-class"><a style="cursor: pointer;" onclick="callpage('mclass/viewClass', 'm-class', 'listmaster');">Master Class</a></li>
                  <li id="m-syear"><a style="cursor: pointer;" onclick="callpage('schoolyear/viewSchoolyear', 'm-syear', 'listmaster');">Master School Year</a></li>
                  <li id="m-nominal"><a style="cursor: pointer;" onclick="callpage('nominal/viewNominalPayment', 'm-nominal', 'listmaster');">Nominal Payment</a></li>
                  <li id="m-major"><a style="cursor: pointer;" onclick="callpage('majors/viewMajors', 'm-major', 'listmaster');">Master Major</a></li>
                   <li id="m-student"><a style="cursor: pointer;" onclick="callpage('student/viewStudent', 'm-student', 'listmaster');">Master Student</a></li>
                  
                </ul>
              </li>

              <li id="listtransaction" class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-square"></i> <span>Tansaction</span></a>
                <ul class="dropdown-menu">
                   <li id="m-paymentspp"><a style="cursor: pointer;" onclick="callpage('paymentspp/viewPaymentspp', 'm-paymentspp', 'listtransaction');">Payment SPP</a></li>
                  <li id="m-cashintrans"><a style="cursor: pointer;" onclick="callpage('cashin/viewCashIn', 'm-cashintrans', 'listtransaction');">Cash In</a></li>
                  <li id="m-cashout"><a style="cursor: pointer;" onclick="callpage('cashout/viewCashOut', 'm-cashout', 'listtransaction');">Cash Out</a></li>
                  
                </ul>
              </li>


              <li id="listreport" class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-square"></i> <span>Report</span></a>
                <ul class="dropdown-menu">
                  <li id="m-reportcashin"><a style="cursor: pointer;" onclick="callpage('reportcashin/viewReportCashIn', 'm-reportcashin', 'listreport');">Cash In</a></li>
                  <li id="m-reportcashout"><a style="cursor: pointer;" onclick="callpage('reportcashout/viewReportCashOut', 'm-reportcashout', 'listreport');">Cash Out</a></li>
                   <li id="m-cashhistory"><a style="cursor: pointer;" onclick="callpage('reportcash/viewReportCash', 'm-cashhistory', 'listreport');">Cash History</a></li>
                   <li id="m-reportpay"><a style="cursor: pointer;" onclick="callpage('reportpayspp/viewReportpayspp', 'm-reportpay', 'listreport');">Payment SPP</a></li>
                  <!-- <li id="m-class"><a style="cursor: pointer;" onclick="callpage('mclass/viewClass', 'm-class', 'listreport');">Tunggakan</a></li>
                  <li id="m-nominal"><a style="cursor: pointer;" onclick="callpage('nominal/viewNominalPayment', 'm-nominal', 'listreport');">Nominal Payment</a></li> -->
                  
                </ul>
              </li>

              
              <li id="listsetup"  class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-cog"></i> <span>Setup</span></a>
                <ul class="dropdown-menu">
                  <li id="s-setup"><a style="cursor: pointer;" onclick="callpage('setupprofile/viewSetupprofile', 's-setup', 'listsetup');">Setup Company</a></li>
                  <li id="s-logo"><a style="cursor: pointer;" onclick="callpage('logo/viewLogo', 's-logo', 'listsetup');">Setup Logo</a></li>
                  <li id="s-print"><a style="cursor: pointer;" onclick="callpage('setupprint/viewSetupPrint', 's-print', 'listsetup');">Setup Print</a></li>
                </ul>
              </li>
            
            </ul>

        </aside>
      </div>

     
   