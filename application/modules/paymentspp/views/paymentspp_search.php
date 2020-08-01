<?php
    $str  = "<div id='cardsppheader'>";
    $str .= "<div class='report list-report animate__animated animate__bounceInLeft'>";
    $str .= "<div class='header-report'>";
    $str .= "<div class='wrap-cap'>";
    $str .= "<div class='cap'>";
    // $str.= "<a href='".base_url()."reportdeposit/viewReportDeposit/print/".urlencode(serialize($keys))."?StartDate=".$StartDate."&EndDate=".$EndDate."' target='/_blank' class='btn btn-icon icon-left btn-secondary' style='margin-left:10px;'><i class='fa fa-print'></i> print</a>";
    // $str.= "<a href='".base_url()."reportdeposit/viewReportDeposit/export/".urlencode(serialize($keys))."?StartDate=".$StartDate."&EndDate=".$EndDate."' target='/_blank' class='btn btn-icon icon-left btn-success' style='margin-left:10px;'><i class='fa fa-file-excel'></i> export</a>";
    // $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Deposit<br/ >Effective Date : ".date_format(date_create($StartDate),"d F Y")." - ".date_format(date_create($EndDate),"d F Y");
    $str .= "</div>";
    $str .= "</div>";
    $str .= "</div>";
    $str .= "<div id='grid' class='gridvie'>";
    $str .= "<div class='gridview'>";
    if(!empty($keys)){

      foreach($keys as $value){ 
        $studentx = $value->studentid;
        $stdntnmx = $value->studentname;
        $classx   = $value->classid;
        $genderx  = $value->gender;
        $dateofx  = $value->dateofbirth;
        $schoolx  = $value->schoolyear;
        $nominalx = $value->nominalamount;  
        $imgurl   = $value->studentimage;
      }


      if($imgurl != ""){
        $uri = "./upload/student/".$imgurl;
        if(file_exists($uri)){
          $urlimg = base_url()."/upload/student/".$imgurl;
        }
        else{
         $urlimg = base_url()."/upload/student/default.jpeg";
        }
      }
      else{
        $urlimg = base_url()."/upload/student/default.jpeg";
      }



      $date = "";
      $tot  = 0;
      $str .= "<table class='table table-sm table-striped'>";
      $str .= "<tr>";
      $str .= "<tbody>";
      $str .= "<td rowspan='7' width='40%' align='center'><img src='".$urlimg."' width='220' height='220' alt='logo' class='shadow-light rounded-circle'></td>";
      $str .= "<td>StudentID</td>";
      $str .= "<td>: ".$studentx."</td>";
      $str .= "</tr>";

      $str .= "<tr>";
      $str .= "<td>StudentName</td>";
      $str .= "<td>: ".$stdntnmx."</td>";
      $str .= "</tr>";

      $str .= "<tr>";
      $str .= "<td>ClassID</td>";
      $str .= "<td>: ".$classx."</td>";
      $str .= "</tr>";

      $str .= "<tr>";
      $str .= "<td>Gender</td>";
      $str .= "<td>: ".$genderx."</td>";
      $str .= "</tr>";

      $str .= "<tr>";
      $str .= "<td>DateOfBirth</td>";
      $str .= "<td>: ".date_format(date_create($dateofx),"d F Y")."</td>";
      $str .= "</tr>";

      $str .= "<tr>";
      $str .= "<td>SchoolYear</td>";
      $str .= "<td>: ".$schoolx."</td>";
      $str .= "</tr>";

      $str .= "<tr>";
      $str .= "<td>Cost SPP</td>";
      $str .= "<td>: ".$nominalx."</td>";
      $str .= "</tr>";

      $str .= "</tbody>";
      $str .= "</table><br>";
    }
    else {
      $str .= "<div class=\"info\">No Data Student</div>";
    }

    $str .= "</div>"; // end div gridview
    $str .= "</div>"; // end div gridvie
    $str .= "</div>"; //report list

    $str .= "<hr>";
    $str .="<div id='cardsppdetail'>";



    $dataspp = "";
    $query = $this->db->query(" SELECT  a.monthid, a.monthname, b.paymentid, b.schoolyear, b.studentid, b.totalpaid, 
                                        b.lastupdateby, b.lastupdatedate
                                FROM    m_mastermonth a
                                LEFT    JOIN
                                          (
                                            SELECT  x.studentid, x.schoolyear, x.paymentid, x.totalpaid, x.isactive, x.monthid, 
                                                    x.lastupdateby, x.lastupdatedate
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
      $dataspp = $query->result();
    }




$xx   = 1;
$str .= "<div class='animate__animated animate__bounceInRight'>";
$paid = "<a class='badge badge-success text-white'><i class='fa fa-check'></i> Paid</a>";
$npaid= "<a class='badge badge-danger text-white'><i class='fa fa-times'></i> Not Paid</a>";
$sst  = "<tr>";
$sed  = "</tr>"; 
$str .= "<table class='table table-striped' id='sortable-table' width='100%'>";
$str .= "<thead>";
$str .= "<tr>";
$str .= "<td colspan='4'>";
$str .= '<a  href="'.base_url().'/paymentspp/viewPaymentspp/printcard/'.$studentx.'/'.$schoolx.'" target="_blank" class="btn btn-secondary"><i class="fa fa-print"></i> Print Card SPP</a>&nbsp;';
$str .= "<button type='button' class='btn btn-info' onclick='showformsppMulti(".$studentx.",  ".$schoolx.", ".$nominalx.");'><i class='fa fa-money-bill-alt'></i> Payment Arrears</button>";
$str .= "</td>";
$str .= "</tr>";

foreach ($dataspp as $key) {

  $stspay = (trim($key->paymentid) != "") ? $paid : $npaid;
  if(trim($key->paymentid) == ""){
    $btn = "<p><button type='button' onclick='showPopupformspp(".$nominalx.", ".$studentx.", ".$key->monthid.", ".$schoolx.");' class='btn btn-primary'><i class='fa fa-money-bill-alt'></i> Pay</button><p>";
    $btn .="<p style='text-align: left font-size: 10px;'>&nbsp;</p>";
  }
  else{
    //$param= "paymentspp/viewPaymentspp/printbill/".$schoolx."/".$studentx."/".$key->monthid;
    $btn  = "<p><button type='button' onclick='printBill(\"/paymentspp/viewPaymentspp/printbill/".$schoolx."/".$studentx."/".$key->monthid."\");' class='btn btn-light' title='Print'><i class='fa fa-print'></i> </button> &nbsp;";
    $btn .= "<button type='button' onclick='PaymentsppDelete(".$studentx.", ".$key->monthid.", ".$schoolx.");' class='btn btn-warning' title='Delete'><i class='fa fa-trash'></i> </button><p>";
    $btn .="<p style='text-align: center; font-size: 9px; color: red;'>Admin By : ".$key->lastupdateby." - ".$key->lastupdatedate."</p>";
  }

  if($xx <= 4){
    $str .= (trim($xx) == 1) ? "<tr>" : "";
    $str .= "<td style='text-align: center'>".$key->monthid." - ".$key->monthname."
            <p>".$stspay."<p>
            ".$btn."
            </td>";
    $str .= (trim($xx) == 4) ? "</tr>" : "";
  }
  else if($xx > 4 ){
    $str .= (trim($xx) == 5) ? "<tr>" : "";
    $str .= "<td style='text-align: center'>".$key->monthid." - ".$key->monthname."
            <p>".$stspay."<p>
            ".$btn."
            </td>";
    $str .= (trim($xx) == 8) ? "</tr>" : "";
  }
   else{
    $str .= (trim($xx) == 9) ? "<tr>" : "";
    $str .= "<td style='text-align: center'>".$key->monthid." - ".$key->monthname."
            <p>".$stspay."<p>
            ".$btn."
            </td>";
    $str .= (trim($xx) == 12) ? "</tr>" : "";
  }
  

  $xx++;
}

//$str .= "</tr>";  

$str .= "</thead>";
$str .= "</table>";
$str .= "</div>";
$str .= "</div>"; // end div report cardsppdetail id
$str .= "</div>"; //end div cardsppheader

echo $str;

?>

<style>
      .gridvie {
        font-family: Times New Roman, Times, serif;
        height: 92%;
        overflow: auto; 
        margin-left: 5px;
        margin-right: 5px;
      }
    
  </style>




