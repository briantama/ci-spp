<div id="reportCashout"> 
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
                  <div class="card-header">
                    <h4>

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
                      <div v-if="validateformRptCashout">
                        <div class="alert alert-danger alert-dismissible show animate__animated animate__shakeY">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ validateformRptCashout}}
                          </div>
                        </div>
                      </div>
                     <!-- end notif-->

                      <div class="buttons">
                     <!-- content button -->
                      </div>
                    </h4>
                    <div class="card-header-action">
                      <!--<form>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model="searchQuery" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>-->
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                           <td>Start Date</td>
                           <td>
                            <vuejs-datepicker style="position: inherit;" :bootstrap-styling="true" :format="customFormatter" ref="startdate" id="startdate" name="startdate" v-model="formReportCashout.startdate"></vuejs-datepicker>
                            <!--<input type="text" ref=startdate" id="startdate" name="startdate" class="form-control" v-model="formReportCashout.startdate" autocomplete="off">-->
                           </td>
                           <td>End Date</td>
                           <td>
                            <vuejs-datepicker style="position: inherit;" :bootstrap-styling="true" :format="customFormatter" ref="enddate" id="enddate" name="enddate" v-model="formReportCashout.enddate"></vuejs-datepicker>
                            <!--<input type="text" ref=enddate" id="enddate" name="enddate" class="form-control" v-model="formReportCashout.enddate" autocomplete="off">-->
                           </td>
                          </tr>
                          <td>Cash Out ID</td>
                           <td><input type="text" ref=depositid" id="depositid" name="depositid" class="form-control" v-model="formReportCashout.depositid"></td>
                           </td>
                           <td>Status Type</td>
                           <td><select type="text" ref=statustype" id="statustype" name="statustype" class="form-control" v-model="formReportCashout.statustype">
                                 <option value="All">All</option>
                                 <option value="Y">Active</option>
                                 <option value="N">Delete</option>
                               </select>
                           </td>
                          </tr>
                          <tr>
                           <td colspan="4">
                            <button type="button" class="btn btn-primary" @click="searchCashout();"><i class="fa fa-check"></i> Search</button>
                            <button type="button" class="btn btn-warning" @click="resetFormRptCashout();"><i class="fa fa-times"></i> Reset</button>
                           </td>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    
                    
                    <hr>
                    <!-- show content search -->
                    <div class="table-responsive">
                     <div v-if="showContentCashout" v-html="showContentCashout">{{showContentCashout}}</div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          
           
          </div>
        </section>
      </div>


</div><!-- end call js -->
 <script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-reportcashout.js"></script>