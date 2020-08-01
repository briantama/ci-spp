<?php
  
    $pco  = "";
    $pcod = "";
    $str  = "<div class='report list-report animate__animated animate__bounceInRight'>";
    $str .= "<div class='header-report'>";
    $str .= "<div class='wrap-cap'>";
    $str .= "<div class='cap'>";
    $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Payment SPP<br/ >School Year : ".$Period;
    $str .= "</div>";
    $str .= "</div>";
    $str .= "</div>";
    $str .= "<div id='grid' class='gridvie'>";
    $str .= "<div class='gridview'>";
    if(!empty($keys)){
      $date = "";
      $tot  = 0;
      $tbl  = "<table>";
      $tbl .= "<thead>";
      $tbl .= "<tr class='total'>";
      $tbl .= "<td>Month</td>";
      $tbl .= "<td>PaymentID</td>";
      $tbl .= "<td>AdminName</td>";
      $tbl .= "<td>Status</td>";
      $tbl .= "<td>Cost SPP</td>";
      $tbl .= "</tr>";
      $tbl .= "</thead>";
      $tbl .= "<tbody>";
      $x = 0;
      $str .= $tbl;
      foreach($keys as $value){ 
        $evenOdd = ($x % 2 == 0) ? "even" : "odd";        
        if ($pco != $value->studentid) {
          if ($pco != "") {
            $str .= "<tr class='total'>";
            $str .= "<td colspan='4'>Total Payment</td>";
            $str .= "<td style=\"text-align: right;\">". number_format($tot) ."</td>";
            $str .= "</tr>";
            $str .= "</tbody>";
            $str .= "</table><br>";
            $str .= $tbl;
            $tot  = 0;
          }
          
          $str .= "<div class='cap-table'>". $value->studentid . " - (" . $value->studentname . " - ".$value->classid.")</div>";
          
          $pco      = $value->studentid;
        }  
        else {
          $pco      = $value->studentid;
        }      
        
        $tot += $value->costspp;
        $cek  = (trim($value->paymentid) != "") ? "Paid" : "Not Paid"; 
        $str .= "<tr class='". $evenOdd ."'>";
        $str .= "<td nowrap title=\"month\">". $value->monthname  ." - ". $value->schoolyear  ."</td>";
        $str .= "<td nowrap title=\"paymentid\">". $value->paymentid ."</td>";
        $str .= "<td nowrap title=\"AdminName\">". $value->lastupdateby  ."</td>";
        $str .= "<td nowrap title=\"Status\">". $cek ."</td>";
        $str .= "<td nowrap title=\"TotalWithdrawal\" style=\"text-align: right;\">". number_format($value->costspp) ."</td>";
        $str .= "</tr>";
        $x++;
      }
      $str .= "<tr class='total'>";
      $str .= "<td colspan='4'>Total Payment</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($tot) ."</td>";
      $str .= "</tr>";
      $str .= "</tbody>";
      $str .= "</table><br>";
    }
    else {
      $str .= "<div class=\"info\">No Data Report Payment SPP/div>";
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
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #6777ef), color-stop(1,#6777ef));
        background:-moz-linear-gradient( center top, #6777ef 5%, #6777ef 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#6777ef', endColorstr='#6777ef');
        border: 1px solid #00557F;
        color: #000;
        
      }
      .gridview table .total td:first-child { text-align: center; border-right: 1px solid #FFF; }
      .gridview table .total td:last-child { text-align: right; }
      .cap-table, .gridview table { width: 98%; margin: 0 auto; }
      .cap-table { color: #000; padding: 5px 0 5px 0; }
  </style>

  <script>window.print();</script>




