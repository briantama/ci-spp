<?php

  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=$filenm.xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  
    $pco  = "";
    $pcod = ""; 
    $str  = "<div class='report list-report'>";
    $str .= "<div class='header-report'>";
    $str .= "<div class='wrap-cap'>";
    $str .= "<div class='cap'>";
    $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Saving Balance<br/ >Effective Date : ".date_format(date_create($StartDate),"d F Y")." - ".date_format(date_create($EndDate),"d F Y");
    $str .= "</div>";
    $str .= "</div>";
    $str .= "</div>";
    $str .= "<div id='grid' class='gridvie'>";
    $str .= "<div class='gridview'>";
    if(!empty($keys)){
      $date = "";
      $tot  = 0;
      $totwd= 0;
      $totsv= 0;
      $tbl  = "<table id='pure-table'>";
      $tbl .= "<thead>";
      $tbl .= "<tr class='total'>";
      $tbl .= "<td>ReferenceID</td>";
      $tbl .= "<td>ReferenceDate</td>";
      $tbl .= "<td>AdminName</td>";
      $tbl .= "<td>TotalDeposit</td>";
      $tbl .= "<td>TotalWithdrawal</td>";
      $tbl .= "<td>TotalSavings</td>";
      $tbl .= "</tr>";
      $tbl .= "</thead>";
      $tbl .= "<tbody>";
      $x = 0;
      $str .= $tbl;
      foreach($keys as $value){ 
        $evenOdd = ($x % 2 == 0) ? "even" : "odd";        
        if ($pco != $value->StudentID) {
          if ($pco != "") {
            $str .= "<tr class='total'>";
            $str .= "<td colspan='3'>Total Saving Balance</td>";
            $str .= "<td style=\"text-align: right;\">". number_format($tot) ."</td>";
            $str .= "<td style=\"text-align: right;\">". number_format($totwd) ."</td>";
            $str .= "<td style=\"text-align: right;\">". number_format($totsv) ."</td>";
            $str .= "</tr>";
            $str .= "</tbody>";
            $str .= "</table><br>";
            $str .= $tbl;
            $tot  = 0;
            $totwd= 0;
            $totsv= 0;
          }
          
          $str .= "<div class='cap-table'>". $value->StudentID . " - (" . $value->StudentName . " - ".$value->ClassID.")</div>";
          
          $pco      = $value->StudentID;
        }  
        else {
          $pco      = $value->StudentID;
        }      
        
        $tot   += $value->TotalDeposit;
        $totwd += $value->TotalWithdrawal;
        $totsv += $value->TotalDeposit - $value->TotalWithdrawal;
        $str .= "<tr class='". $evenOdd ."'>";
        $str .= "<td nowrap title=\"ReferenceID\">". $value->ReferenceID  ."</td>";
        $str .= "<td nowrap title=\"ReferenceDate\">". date_format(date_create($value->ReferenceDate),"d F Y") ."</td>";
        $str .= "<td nowrap title=\"AdminName\">". $value->LastUpdateBy  ."</td>";
        $str .= "<td nowrap title=\"TotalDeposit\" style=\"text-align: right;\">". number_format($value->TotalDeposit) ."</td>";
        $str .= "<td nowrap title=\"TotalWithdrawal\" style=\"text-align: right;\">". number_format($value->TotalWithdrawal) ."</td>";
        $str .= "<td nowrap title=\"TotalSavings\" style=\"text-align: right;\">". number_format($totsv) ."</td>";
        $str .= "</tr>";
        $x++;
      }
      $str .= "<tr class='total'>";
      $str .= "<td colspan='3'>Total Saving Balance</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($tot) ."</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($totwd) ."</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($totsv) ."</td>";
      $str .= "</tr>";
      $str .= "</tbody>";
      $str .= "</table><br>";
    }
    else {
      $str .= "<div class=\"info\">No Data Report Saving Balance</div>";
    }

    $str .= "</div>"; // end div gridview
    $str .= "</div>"; // end div gridvie
    $str .= "</div>"; // end div report

    echo $str;


?>


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





