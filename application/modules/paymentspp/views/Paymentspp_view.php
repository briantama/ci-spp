<div id="Paymentspp"> 
 <div class="main-content animate__animated animate__bounceInLeft">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $title; ?> </h1>

            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Components</a></div>
              <div class="breadcrumb-item"><?php echo $title; ?></div>
            </div>
          </div>

          <div class="section-body">
            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
              <div class="col-12">
                <div class="card">
               
                  <div class="card-body p-0">

                     <!-- notif-->
                      <div class="col-md-3 shownotifmsg animate__animated animate__backInRight" v-if="errorMessage">
                         <div class="alert alert-danger alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ errorMessage }}
                          </div>
                        </div>
                      </div>
                      <!-- end notif-->

                    <!-- notif-->
                      <div class="col-12 animate__animated animate__shakeY" v-if="validateformSPP">
                        <div class="alert alert-danger alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ validateformSPP}}
                          </div>
                        </div>
                      </div>
                     <!-- end notif-->

                      <!-- notif form spp-->
                     <div id="notif-msg"></div>
                      <!-- end notif-->


                    <div class="table-responsive">
                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                           <td>School Year</td>
                           <td>
                              <select ref="periodyear" id="periodyear" name="periodyear" class="form-control" v-model="formSPP.periodyear">
                                <option v-for="scperiod in periods" :value="scperiod.schoolyear">{{scperiod.schoolyear}}</option>
                              </select>
                           </td>
                           <td>Student ID</td>
                           <td>
                             <div class="card-body">
                            <input type="text" id="studentid" name="studentid" ref=studentid"  class="form-control" v-model="formSPP.studentid" @keyup="getDataStudent()" autocomplete="off">

                            <!-- show search -->
                           <div class="selectdatas" v-if="search_data.length">
                            <ul class="list-group">
                              <a href="#" class="list-group-item" v-for="data1 in search_data" @click="getNameStudent(data1.keystudent)">{{ data1.student }}</a>
                            </ul>
                          </div>
                           </td>
                          </tr>
                          
                          <tr>
                           <td colspan="4">
                            <button type="button" class="btn btn-primary" @click="searchSPP();"><i class="fa fa-check"></i> Search</button>
                            <button type="button" class="btn btn-warning" @click="resetFormSPP();"><i class="fa fa-times"></i> Reset</button>
                           </td>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    
                    <hr>
                    <!-- show content search -->
                    <div class="table-responsive">

                      <!-- <div v-if="showinfoStudent"> -->
                     <!--    <table>
                          <tr v-for="val in showinfoStudent">
                            <td>{{val.studentname}}</td>
                          </tr>
                        </table> -->
<!-- 
                          <table class='table table-sm table-striped animate__animated animate__bounceInLeft'> 
                            <tr>
                              <td rowspan='7' width='30%'>foto</td>
                              <td>Student ID</td>
                              <td>: {{showstudent}}</td>
                            </tr>
                            <tr>
                              <td>Student Name</td>
                              <td>: {{showstudentname}}</td>
                            </tr>
                            <tr>
                              <td>ClassID</td>
                              <td>: {{showclass}}</td>
                            </tr>
                            <tr>
                              <td>Gender</td>
                              <td>: {{showgender}}</td>
                            </tr>
                            <tr>
                              <td>DateOfBirth</td>
                              <td>: {{showdateofbirth}}</td>
                            </tr>
                            <tr>
                              <td>School Year</td>
                              <td>: {{showschoolyear}}</td>
                            </tr>
                            <tr>
                              <td>Cost SPP</td>
                              <td>: {{shownominal}}</td>
                            </tr>

                          </table>
                      </div> -->

                      <!-- CARD SPP-->
                    <!--   <div v-if="showinfoCardSPP">
                      <table border="1" class='table table-striped animate__animated animate__bounceInRight' id='sortable-table'>
                        <tr>
                          <td colspan="4"><button type='button' class='btn btn-success' @click='printCardSPP();'><i class='fa fa-print'></i> Print Card SPP</button></td>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>4</td>
                        </tr>

                        <tbody v-for="(keys, index) in showinfoCardSPP">
                        <tr>
                          <td v-if="keys.monthid == 3">{{index}}-{{keys.monthid}}</td>
                          <td v-if="keys.monthid == 4">{{index}}-{{keys.monthid}}</td>
                        </tr>
                        </tbody>

                      </table>
                      </div> -->

                     <div v-if="showContentSPP" v-html="showContentSPP">{{showContentSPP}}</div>
                     <!-- <div id="showctcspp"></div> -->
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          
           
          </div>
        </section>
      </div>




<!-- form multi pay-->
<div class="modal fade animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="formsppmulti">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="blokform">
              <div class="modal-header">
                <h5 class="modal-title">Form Payment SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

              <form method="post" action="" name="f_paysppml" id="f_paysppml" >
              <div id="notif-paysppml"></div>
                  <div class="table-responsive">
                    <table class="table table-striped">
                       <tr>
                        <td>Start Month *</td>
                        <td>
                          <select type="text" id="monthidmx" name="monthidmx" onchange="calFormSPPMonth();" class="form-control" >
                              <option value="1">Januari</option>
                              <option value="2">Febuari</option>
                              <option value="3">Maret</option>
                              <option value="4">April</option>
                              <option value="5">Mei</option>
                              <option value="6">Juni</option>
                              <option value="7">Juli</option>
                              <option value="8">Agustus</option>
                              <option value="9">November</option>
                              <option value="10">Oktober</option>
                              <option value="11">November</option>
                              <option value="12">Desember</option>
                          </select>
                        </td>
                      </tr>
                       <tr>
                        <td>End Month *</td>
                        <td>
                          <select type="text" id="emonthidmx" name="emonthidmx" onchange="calFormSPPMonth();" class="form-control" >
                              <option value="1">Januari</option>
                              <option value="2">Febuari</option>
                              <option value="3">Maret</option>
                              <option value="4">April</option>
                              <option value="5">Mei</option>
                              <option value="6">Juni</option>
                              <option value="7">Juli</option>
                              <option value="8">Agustus</option>
                              <option value="9">November</option>
                              <option value="10">Oktober</option>
                              <option value="11">November</option>
                              <option value="12">Desember</option>
                          </select>
                        </td>
                      </tr>

                      <tr>
                        <td>StudentID *</td>
                        <td>
                          <input type="text" id="studenmx" name="studenmx" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                       <tr>
                        <td>School Year *</td>
                        <td>
                          <input type="text" id="schoolyearmx" name="schoolyearmx" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td>Cost SPP *</td>
                        <td>
                          <input type="text" id="costsppmx" name="costsppmx" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td>Total Cost SPP *</td>
                        <td>
                          <input type="text" id="totcostsppmx" name="totcostsppmx" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                       <tr>
                        <td>Payment Type *</td>
                        <td>
                          <select id="paytypemx" name="paytypemx" class="form-control">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Total Pay *</td>
                        <td>
                          <input type="number" id="totpaymx" name="totpaymx" onchange="calFormSPPML();" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td>Refund *</td>
                        <td>
                          <input type="number" id="refundmx" name="refundmx" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                     
                    </table>
                  </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" onclick="return PaymentsppSaveMulti();"><i class="fa fa-check"></i> Save changes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
               </form>
            </div>
          </div>
        </div>




<!-- form class-->
<div class="modal fade animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="formcardspp">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="blokform">
              <div class="modal-header">
                <h5 class="modal-title">Form Payment SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

              <form method="post" action="" name="f_payspp" id="f_payspp" >
              <div id="notif-payspp"></div>
                  <div class="table-responsive">
                    <table class="table table-striped">
                       <tr>
                        <td>Month *</td>
                        <td>
                          <input type="text" id="monthid" name="monthid" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td>StudentID *</td>
                        <td>
                          <input type="text" id="studenx" name="studenx" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                       <tr>
                        <td>School Year *</td>
                        <td>
                          <input type="text" id="schoolyear" name="schoolyear" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                      <tr>
                        <td>Cost SPP *</td>
                        <td>
                          <input type="number" id="costspp" name="costspp" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                       <tr>
                        <td>Payment Type *</td>
                        <td>
                          <select id="paytype" name="paytype" class="form-control">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Total Pay *</td>
                        <td>
                          <input type="number" id="totpay" name="totpay" onchange="calFormSPP();" class="form-control">
                        </td>
                      </tr>
                      <tr>
                        <td>Refund *</td>
                        <td>
                          <input type="number" id="refund" name="refund" class="form-control" readonly="readonly">
                        </td>
                      </tr>
                     
                    </table>
                  </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" onclick="return PaymentsppSave();"><i class="fa fa-check"></i> Save changes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
               </form>
            </div>
          </div>
        </div>




</div><!-- end call js -->
 <script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-paymentspp.js"></script>

 <style type="text/css">
   
   @media (min-width: 768px) {
    .selectdatas {
      outline: none;
  height: 50px;
  line-height: 50px;
  padding:0px 20px;
    }
}

 </style>