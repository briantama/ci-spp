<?php
  
    $pco  = "";
    $pcod = ""; 
    $str  = "<div class='report list-report'>";
    $str .= "<div class='header-report'>";
    $str .= "<div class='wrap-cap'>";
    $str .= "<div class='cap'>";
    $str.= "<div class='cap' style='text-align: center; font-weight: bold;'> Report Cash History<br/ >Effective Date : ".date_format(date_create($StartDate),"d F Y")." - ".date_format(date_create($EndDate),"d F Y");
    $str .= "</div>";
    $str .= "</div>";
    $str .= "</div>";
    $str .= "<div id='grid' class='gridvie'>";
    $str .= "<div class='gridview'>";
    if(!empty($keys)){
      $date = "";
      $tot  = 0;
      $totn = 0;
      $totx = 0;
      $tbl  = "<table id='pure-table'>";
      $tbl .= "<thead>";
      $tbl .= "<tr class='total'>";
      $tbl .= "<td>Ref ID</td>";
      $tbl .= "<td>Ref Date</td>";
      $tbl .= "<td>AdminName</td>";
      $tbl .= "<td>Description</td>";
      $tbl .= "<td>Amount In</td>";
      $tbl .= "<td>Amount Out</td>";
      $tbl .= "<td>Amount Total</td>";
      $tbl .= "</tr>";
      $tbl .= "</thead>";
      $tbl .= "<tbody>";
      $x = 0;
      $str .= $tbl;
      foreach($keys as $value){ 
        $evenOdd = ($x % 2 == 0) ? "even" : "odd";        
        
        $tot   += $value->cashamountout;
        $totn  += $value->cashamount;
        $totx  += $value->cashamount - $value->cashamountout;
        $str .= "<tr class='". $evenOdd ."'>";
        $str .= "<td nowrap title=\"cashoutid\">". $value->refid  ."</td>";
        $str .= "<td nowrap title=\"cashdate\">". date_format(date_create($value->cashdate),"d F Y") ."</td>";
        $str .= "<td nowrap title=\"AdminName\">". $value->lastupdateby  ."</td>";
        $str .= "<td nowrap title=\"Description\">". $value->description  ."</td>";
        $str .= "<td nowrap title=\"amountin\" style=\"text-align: right;\">". number_format($value->cashamount) ."</td>";
        $str .= "<td nowrap title=\"amountout\" style=\"text-align: right;\">". number_format($value->cashamountout) ."</td>";
        $str .= "<td nowrap title=\"amount\" style=\"text-align: right;\">". number_format($totx) ."</td>";
        $str .= "</tr>";
        $x++;
      }
      $str .= "<tr class='total'>";
      $str .= "<td colspan='4'>Total Cash</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($totn ) ."</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($tot ) ."</td>";
      $str .= "<td style=\"text-align: right;\">". number_format($totx ) ."</td>";
      $str .= "</tr>";
      $str .= "</tbody>";
      $str .= "</table><br>";
    }
    else {
      $str .= "<div class=\"info\">No Data Cash History</div>";
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




