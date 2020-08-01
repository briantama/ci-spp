<?php

  //chart deposit
  $chartcashin = array(0);
  $qry = $this->db->query("
                            SELECT Z.monthid, Z.monthname, COALESCE(Y.cashamount,0) AS cashamount
                            FROM m_mastermonth Z
                            LEFT JOIN (
                              SELECT EXTRACT(MONTH FROM cashdate) AS Bulan, COALESCE(SUM(a.cashamount),0) AS cashamount
                              FROM   m_cashin a
                              WHERE  a.isactive = 'Y'
                              GROUP  BY EXTRACT(MONTH FROM cashdate)
                              ORDER  BY EXTRACT(MONTH FROM cashdate)

                                ) Y ON Z.monthid=Y.Bulan
                            ORDER BY Z.monthid

                           ");
  if ($qry->num_rows() > 0) {
      $chartcashx = $qry->result();
      foreach ($chartcashx as $key) {
        $month[]       = $key->monthname;
        $chartcashin[] = $key->cashamount;
      }
      
  }


  //chart withdrawal
  $chartcashout = array(0);
  $res = $this->db->query("
                            SELECT Z.monthid, Z.monthname, COALESCE(Y.cashamountout,0) AS cashamountout
                            FROM m_mastermonth Z
                            LEFT JOIN (
                                SELECT EXTRACT(MONTH FROM cashdate) AS Bulan, COALESCE(SUM(a.cashamountout),0) AS cashamountout
                                FROM   m_cashout a
                                WHERE  a.isactive = 'Y'
                                GROUP  BY EXTRACT(MONTH FROM cashdate)
                                ORDER  BY EXTRACT(MONTH FROM cashdate)

                                ) Y ON Z.MonthID=Y.Bulan
                            ORDER BY Z.MonthID

                           ");
  if ($res->num_rows() > 0) {
      $chartcasht = $res->result();
      foreach ($chartcasht as $key) {
        $monthwd[]         = $key->monthname;
        $chartcashout[]    = $key->cashamountout;
      }
      
  }



  //master data
  //student
  $totstd = 0;
  $stu = $this->db->query("

                          SELECT  COUNT(studentid) as totalstudent
                          FROM    m_student 
                          WHERE   isactive = 'Y'
                          ");
  if ($stu->num_rows() > 0) {
    $keystu = $stu->row();
    $totstd = $keystu->totalstudent;
  }


//deposit
  $totin = 0;
  $dpo = $this->db->query("
                              SELECT COALESCE(SUM(cashamount),0) AS totalcashin
                              FROM   m_cashin 
                              WHERE  isactive = 'Y'
                          ");
  if ($dpo->num_rows() > 0) {
    $keydpo = $dpo->row();
    $totin  = $keydpo->totalcashin;
  }



  $totout = 0;
  $dpo = $this->db->query("
                              SELECT COALESCE(SUM(cashamountout),0) AS totalcashout
                              FROM   m_cashout
                              WHERE  isactive = 'Y'
                          ");
  if ($dpo->num_rows() > 0) {
    $keydpo  = $dpo->row();
    $totout  = $keydpo->totalcashout;
  }


  //withdrawal
  $totspp = 0;
  $whl = $this->db->query("
                              SELECT COALESCE(sum(costspp),0) AS costspp
                              FROM   m_paymentspp 
                              WHERE  isactive = 'Y'
                          ");
  if ($whl->num_rows() > 0) {
    $keywdh = $whl->row();
    $totspp = $keywdh->costspp;
  }


?>



 <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fa fa-users fa-2x" style="color: #ffff;"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Data Student</h4>
                  </div>
                  <div class="card-body">
                      <?php echo $totstd; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-money-bill"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Cash In</h4>
                  </div>
                  <div class="card-body">
                    <?php echo number_format($totin); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-money-bill"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Cash Out</h4>
                  </div>
                  <div class="card-body">
                    <?php echo number_format($totout); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Payment</h4>
                  </div>
                  <div class="card-body">
                    <?php echo number_format($totspp); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
         

         <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Line Chart Cash In</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="myChart"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Bar Chart Cash Out</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="myChart2"></canvas>
                  </div>
                </div>
              </div>
            </div>
    
         
        </section>
      </div>



<script type="text/javascript">

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?php echo json_encode($month); ?>,
    datasets: [{
      label: 'Sales',
      data: [<?php echo join($chartcashin,','); ?>],
      borderWidth: 2,
      backgroundColor: 'rgba(63,82,227,.8)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0,
      pointRadius: 3.5,
      pointBackgroundColor: 'transparent',
      pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          // display: false,
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          callback: function(value, index, values) {
            //return 'Rp' + value;
            return value
          }
        }
      }],
      xAxes: [{
        gridLines: {
          display: false,
          tickMarkLength: 15,
        }
      }]
    },
  }
});
  

var ctx = document.getElementById("myChart2").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?php echo json_encode($monthwd); ?>,
    datasets: [{
      label: 'Sales',
      data: [<?php echo join($chartcashout,','); ?>],
      borderWidth: 2,
      backgroundColor: 'rgba(63,82,227,.8)',
      borderWidth: 0,
      borderColor: 'transparent',
      pointBorderWidth: 0,
      pointRadius: 3.5,
      pointBackgroundColor: 'transparent',
      pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          // display: false,
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          callback: function(value, index, values) {
            //return 'Rp' + value;
            return value
          }
        }
      }],
      xAxes: [{
        gridLines: {
          display: false,
          tickMarkLength: 15,
        }
      }]
    },
  }
});

</script>