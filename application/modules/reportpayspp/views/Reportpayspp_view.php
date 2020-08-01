<div id="reportPayspp"> 
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
                  
                   <!-- notif-->
                      <div class="col-md-3 shownotifmsg" v-if="errorMessage">
                         <div class="alert alert-danger alert-dismissible show animate__animated animate__backInRight">
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
                      <div v-if="validateformRptPay">
                        <div class="alert alert-danger alert-dismissible show animate__animated animate__shakeY">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ validateformRptPay}}
                          </div>
                        </div>
                      </div>
                     <!-- end notif-->


                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                           <td>School Year</td>
                           <td>
                              <select ref="periodyear" id="periodyear" name="periodyear" class="form-control" v-model="formReportPay.periodyear">
                                <option v-for="scperiod in periods" :value="scperiod.schoolyear">{{scperiod.schoolyear}}</option>
                              </select>
                           </td>
                          
                           <td>Student ID</td>
                           <td><input type="text" ref=studentid" id="studentid" name="studentid" class="form-control" v-model="formReportPay.studentid" @keyup="getDataStudent()" autocomplete="off">
                            <!-- show search -->
                           <div class="panel-footer" v-if="search_data.length">
                            <ul class="list-group">
                              <a href="#" class="list-group-item" v-for="data1 in search_data" @click="getNameStudent(data1.keystudent)">{{ data1.student }}</a>
                            </ul>
                          </div>
                           </td>
                          </tr>
                          <tr>
                           <td>Class ID</td>
                           <td><input type="text" ref=classid" id="classid" name="classid" class="form-control" v-model="formReportPay.classid" @keyup="getDataClass()" autocomplete="off">
                             <!-- show search -->
                           <div class="panel-footer" v-if="search_datacl.length">
                            <ul class="list-group">
                              <a href="#" class="list-group-item" v-for="data1 in search_datacl" @click="getNameClass(data1.keyclassid)">{{ data1.classid }}</a>
                            </ul>
                          </div>
                           </td>
                            <td>Payment ID</td>
                           <td><input type="text" ref=paymentid" id="paymentid" name="paymentid" class="form-control" v-model="formReportPay.paymentid"></td>

                   
                          </tr>
                          <tr>
                           <td colspan="4">
                            <button type="button" class="btn btn-primary" @click="searchPayspp();"><i class="fa fa-check"></i> Search</button>
                            <button type="button" class="btn btn-warning" @click="resetFormRptPay();"><i class="fa fa-times"></i> Reset</button>
                           </td>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    
                    <hr>
                    <!-- show content search -->
                    <div class="table-responsive">
                     <div v-if="showContentPay" v-html="showContentPay">{{showContentPay}}</div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          
           
          </div>
        </section>
      </div>


</div><!-- end call js -->
 <script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-reportpayspp.js"></script>