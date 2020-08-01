<div id="vueSetupPrint"> 


  <!-- notif-->
                      <div class="col-md-3 shownotifmsg shownotifmsg animate__animated animate__backInRight" v-if="errorMessage">
                        <div class="alert alert-danger alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ errorMessage }}
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3 shownotifmsg shownotifmsg animate__animated animate__backInRight" v-if="successMessage">
                         <div class="alert alert-success alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-check"></i> {{ successMessage }}
                          </div>
                        </div>
                      </div>

                      <!-- end notif-->



 <!-- Main Content -->
      <div class="main-content animate__animated animate__bounceInLeft">
        <section class="section">
          <div class="section-header">
            <div class="section-header-back">
              <a href="features-settings.html" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1><?php echo $title; ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item active"><a href="#">Settings</a></div>
              <div class="breadcrumb-item"><?php echo $title; ?></div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">All About General Settings</h2>
            <p class="section-lead">
              You can adjust all general settings here
            </p>

            <div id="output-status"></div>
            <div class="row">
              
              <div class="col-md-12">
                <form id="setting-form">
                  <div class="card" id="settings-card">
                    <div class="card-header">
                      <h4>General Settings</h4>
                    </div>
                    <div class="card-body">

                    <!-- notif-->
                      <div v-if="validateformStp">
                        <div class="alert alert-danger alert-dismissible show alert-dismissible show animate__animated animate__shakeY">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ validateformStp }}
                          </div>
                        </div>
                      </div>
                    <!-- end notif-->

                      <!-- <p class="text-muted">General settings such as, site title, site description, address and so on.</p> -->
                      
                      <div class="form-group row">
                        <label class="form-control-label col-sm-3 mt-3 text-md-right">Print Image</label>
                        <div class="col-sm-6 col-md-9">
                          <div v-html="uploadedImageLogo" align="center"></div>
                        </div>
                      </div>

                      <input type="hidden" name="setupid" id="setupid" class="form-control" v-model="formPrint.setupid">

                      <div class="form-group row align-items-center">
                        <label for="site-title" class="form-control-label col-sm-3 text-md-right"> Setup Header</label>
                        <div class="col-sm-6 col-md-9">
                          <input type="text" ref="setuphead" name="setuphead" id="setuphead" class="form-control" v-model="formPrint.setuphead">
                        </div>
                      </div>

                      <div class="form-group row align-items-center">
                        <label for="site-title" class="form-control-label col-sm-3 text-md-right"> Setup Footer</label>
                        <div class="col-sm-6 col-md-9">
                          <input type="text" ref="setupfoot" name="setupfoot" id="setupfoot" class="form-control" v-model="formPrint.setupfoot">
                        </div>
                      </div>

                      <div class="form-group row align-items-center">
                        <label for="site-title" class="form-control-label col-sm-3 text-md-right"> Setup Image Show</label>
                        <div class="col-sm-6 col-md-9">
                          <select ref="setupimg" name="setupimg" id="setupimg" class="form-control" v-model="formPrint.setupimg">
                            <option value="N">No</option>
                            <option value="Y">Yes</option>
                          </select>
                        </div>
                      </div>

                       <div class="form-group row align-items-center">
                        <label for="site-title" class="form-control-label col-sm-3 text-md-right"> Image Print</label>
                        <div class="col-sm-6 col-md-9">
                            <!-- <input type="file" ref="file" name="file" class="custom-file-input" id="file" v-model="formPrint.file"> -->
                           <input type="file" ref="file" v-model="formPrint.file" class="form-control"/>
                          <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                        </div>
                      </div>

                      <div class="form-group row align-items-center">
                        <div class="col-sm-6 col-md-9">
                          <button type="button" class="btn btn-primary" @click="addPrint();"><i class="fa fa-check"></i> Save changes</button>
                          <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                          <button type="button" class="btn btn-success" @click="testPrint('setupprint/viewSetupPrint/print');"><i class="fa fa-print"></i> Test Print</button>
                        </div>
                      </div>
                    
                    </div>
                   
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>

  
</div>
<script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-setupprint.js"></script>
