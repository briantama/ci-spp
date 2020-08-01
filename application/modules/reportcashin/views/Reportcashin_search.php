<?php
  
    $pco  = "";
    $pcod = "";
    $str  = "<div class='report list-report animate__animated animate__bounceInLeft'>";
    $str .= "<div class='header-report'>";
    $str .= "<div class='wrap-cap'>";
    $str .= "<div class='cap'>";
    $str.= "<a href='".base_url()."reportcashin/viewReportCashIn/print/".urlencode(serialize($keys))."?StartDate=".$StartDate."&EndDate=".$EndDate."' target='/_blank' class='btn btn-icon icon-left btn-secondary' style='margin-left:10px;'><i class='fa fa-print'></i> print</a>";
    $str.= "<a href='".base_url()."reportcashin/viewReportCashIn/export/".urlencode(serialize($keys))."?StartDate=".$StartDate."&EndDate=".$EndDate."' target='/_blank' class='btn btn-icon icon-left btn-success' style='margin-left:10px;'><i class='fa fa-file-excel'></i> export</a>";
    $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Cash In<br/ >Effective Date : ".date_format(date_create($StartDate),"d F Y")." - ".date_format(date_create($EndDate),"d F Y");
    $str .= "</div>";
    $str .= "</div>";
    $str .= "</div>";
    $str .= "<div id='grid' class='gridvie'>";
    $str .= "<div class='gridview'>";
    if(!empty($keys)){
      $date = "";
      $tot  = 0;
      $tbl  = "<table id='pure-table'>";
      $tbl .= "<thead>";
      $tbl .= "<tr class='total'>";
      $tbl .= "<td>CashInID</td>";
      $tbl .= "<td>CashDate</td>";
      $tbl .= "<td>AdminName</td>";
      $tbl .= "<td>Description</td>";
      $tbl .= "<td>Amount</td>";
      $tbl .= "</tr>";
      $tbl .= "</thead>";
      $tbl .= "<tbody>";
      $x = 0;
      $str .= $tbl;
      foreach($keys as $value){ 
        $evenOdd = ($x % 2 == 0) ? "even" : "odd";        
        
        $tot   += $value->cashamount;
        $str .= "<tr class='". $evenOdd ."'>";
        $str .= "<td nowrap title=\"cashinid\">". $value->cashinid  ."</td>";
        $str .= "<td nowrap title=\"cashdate\">". date_format(date_create($value->cashdate),"d F Y") ."</td>";
        $str .= "<td nowrap title=\"AdminName\">". $value->lastupdateby  ."</td>";
        $str .= "<td nowrap title=\"Description\">". $value->description  ."</td>";
        $str .= "<td nowrap title=\"TotalSavings\" style=\"text-align: right;\">". number_format($value->cashamount) ."</td>";
        $str .= "</tr>";
        $x++;
      }
      $str .= "<tr class='total'>";
      $str .= "<td colspan='4'>Total Cash In</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($tot) ."</td>";
      $str .= "</tr>";
      $str .= "</tbody>";
      $str .= "</table><br>";
    }
    else {
      $str .= "<div class=\"info\">No Data Cash In</div>";
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




