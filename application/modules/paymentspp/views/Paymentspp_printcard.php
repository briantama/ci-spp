<div class='report list-report'>
<div class='header-report'>
<div class='wrap-cap'>
<div class='cap' style='text-align: center; font-weight: bold;'>Card SPP<br/ >School Year : <?php echo $scyear; ?>
</div>
</div>
</div>

<div id='grid' class='gridvie'>
<div class='gridview'>
<div class='cap-table'>&nbsp;</div>


<?php

$stdx = "";
$stnx = "";
$clsx = "";
$dtox = "";
$gdrx = "";
$nmlx = "";
$yerx = "";

$qry = $this->db->query("
                              
                              SELECT  a.studentid, a.classid, a.studentname, a.gender, a.dateofbirth, a.email, 
                                      a.adress, a.joindate, a.schoolyear, a.isactive, b.classname, d.nominalamount
                              FROM    m_student a 
                              INNER   JOIN m_class b on a.classid=b.classid
                              INNER   JOIN m_schoolyear c on a.schoolyear=c.schoolyear
                              INNER   JOIN m_nominalpayment d on a.classid=d.classid and a.schoolyear=d.schoolyear
                              WHERE   a.isactive ='Y'
                                      AND a.schoolyear ='".$scyear."'
                                      AND a.studentid  ='".$studenx."'
                                     
                            ");
            
      
if ($qry->num_rows() > 0) {
  $val  = $qry->row();
  $stdx = $val->studentid;
  $stnx = $val->studentname;
  $clsx = $val->classid;
  $dtox = $val->dateofbirth;
  $gdrx = $val->gender;
  $nmlx = $val->nominalamount;
  $yerx = $val->schoolyear;
}



$xx   = 1;
$paid = "<a class='badge badge-success text-white'><i class='fa fa-check'></i> Paid</a>";
$npaid= "<a class='badge badge-danger text-white'><i class='fa fa-times'></i> Not Paid</a>";

$str  = "<table border='1' cellspacing='0'>";
$str .= "<tr>";
$str .= "<td>StudentID</td>";
$str .= "<td colspan='3'>: ".$stdx."</td>";
$str .= "</tr>";
$str .= "<tr>";
$str .= "<td>StudentName</td>";
$str .= "<td colspan='3'>: ".$stnx."</td>";
$str .= "</tr>";
$str .= "<tr>";
$str .= "<td>Classid</td>";
$str .= "<td colspan='3'>: ".$clsx."</td>";
$str .= "</tr>";
$str .= "<tr>";
$str .= "<td>DateOfBirth</td>";
$str .= "<td colspan='3'>: ".date_format(date_create($dtox),"d F Y")."</td>";
$str .= "</tr>";
$str .= "<tr>";
$str .= "<td>Gender</td>";
$str .= "<td colspan='3'>: ".$gdrx."</td>";
$str .= "</tr>";
$str .= "<tr>";
$str .= "<td>Cost SPP</td>";
$str .= "<td colspan='3'>: ".number_format($nmlx)."</td>";
$str .= "</tr>";
$str .= "<tr>";
$str .= "<td>School Year</td>";
$str .= "<td colspan='3'>: ".$yerx."</td>";
$str .= "</tr>";


foreach ($dataspp as $key) {

  $stspay = (trim($key->paymentid) != "") ? $paid : $npaid;
  if(trim($key->paymentid) == ""){
    // $btn = "<p><button type='button' onclick='showPopupformspp(".$nominalx.", ".$studentx.", ".$key->monthid.", ".$schoolx.");' class='btn btn-primary'><i class='fa fa-money-bill-alt'></i> Pay</button><p>";
    $btn  ="<p style='text-align: left font-size: 10px;'>&nbsp;</p>";
  }
  else{
    // $btn  = "<p><button type='button' onclick='PaymentsppPrint(".$studentx.", ".$key->monthid.", ".$schoolx.");' class='btn btn-light'><i class='fa fa-print' title='Print'></i> print</button> &nbsp;";
    // $btn .= "<button type='button' onclick='PaymentsppDelete(".$studentx.", ".$key->monthid.", ".$schoolx.");' class='btn btn-warning'><i class='fa fa-trash' title='Delete'></i> delete</button><p>";
    $btn  ="<p style='text-align: center; font-size: 10px; color: red;'>Admin By : ".$key->lastupdateby." - ".$key->lastupdatedate."</p>";
  }

  if($xx <= 4){
    $str .= (trim($xx) == 1) ? "<tr>" : "";
    $str .= "<td height='40' style='text-align: center'>".$key->monthid." - ".$key->monthname."
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

echo $str;

?>

</div>
</div>
</div>


<style>
      .gridvie {
        font-family: Times New Roman, Times, serif;
        height: 92%;
        overflow: auto; 
      }
      .gridview table { border: 1px solid #00557F; }
      .gridview table .total td {
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ff66b8), color-stop(1,#ff66b8));
        background:-moz-linear-gradient( center top, #ff66b8 5%, #ff66b8 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff66b8', endColorstr='#ff66b8');
        border: 1px solid #00557F;
        color: #000;
        
      }
      .gridview table .total td:first-child { text-align: center; border-right: 1px solid #FFF; }
      .gridview table .total td:last-child { text-align: right; }
      .cap-table, .gridview table { width: 98%; margin: 0 auto; }
      .cap-table { color: #000; padding: 5px 0 5px 0; }
  </style>

<script>window.print();</script>