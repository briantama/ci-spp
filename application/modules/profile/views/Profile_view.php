<div id="vueProfile">
  
  <!-- Main Content -->
      <div class="main-content animate__animated animate__bounceInLeft">
        <section class="section">
          <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">Profile</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">Hi, <?php echo $this->session->userdata('nama');?></h2>
            <p class="section-lead">
              Change information about yourself on this page.
            </p>

            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                    <!-- <img alt="image" src="<?php echo base_url(); ?>stisla-master/assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture"> -->

                    <div v-html="uploadedImage" align="center"></div>

                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Posts</div>
                        <div class="profile-widget-item-value">187</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Followers</div>
                        <div class="profile-widget-item-value">6,8K</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Following</div>
                        <div class="profile-widget-item-value">2,1K</div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?php echo $this->session->userdata('nama');?> <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> Staff Administrasi</div></div>
                    <br>
                    <input type="file" ref="file" @change="uploadImage" class="btn btn-primary"/>

                  </div>
                  <div class="card-footer text-center">
                    <div class="font-weight-bold mb-2">Follow <?php echo $this->session->userdata('nama');?> On</div>
                    <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-github mr-1">
                      <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-instagram">
                      <i class="fab fa-instagram"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                          <!-- notif-->
                          <div v-if="validateformProfile">
                            <div class="alert alert-danger alert-dismissible show alert-dismissible show animate__animated animate__shakeY">
                              <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                  <span>&times;</span>
                                </button>
                                <i class="fa fa-times"></i> {{ validateformProfile }}
                              </div>
                            </div>
                          </div>
                          <!-- end notif-->

                          <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                              <input type="hidden" id="idxadmin" ref="idxadmin" v-model="formProfile.idxadmin" class="form-control">
                              <tbody>
                                <tr>
                                <td>Name</td>
                                <td><input type="namex" id="namex" ref="namex" v-model="formProfile.namex" class="form-control"></td>
                              </tr>
                             <!-- <tr>
                                <td>UserName</td>
                                <td>: {{detailprofile.UserName}} </td>
                              </tr>-->
                              <tr>
                                <td>Email</td>
                                <td><input type="emailx" id="emailx" ref="emailx" v-model="formProfile.emailx" class="form-control"></td>
                              </tr>
                              <tr>
                                <td>Date Of Birth</td>
                                <td>
                                  <vuejs-datepicker style="position: inherit;" :bootstrap-styling="true" :format="customFormatter" ref="dateofx" id="dateofx" name="dateofx" v-model="formProfile.dateofx"></vuejs-datepicker>
                                  <!-- <input type="dateofx" id="dateofx" ref="dateofx" v-model="formProfile.dateofx" class="form-control"> --> </td>
                              </tr>
                              <tr>
                                <td>Super User</td>
                                <td><input type="supuserx" id="supuserx" ref="supuserx" v-model="formProfile.supuserx" readonly="readonly" class="form-control"></td>
                              </tr>
                              </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button type="button" class="btn btn-primary" @click="updateProfile();"><i class="fa fa-check"></i> Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      
      
                      <!-- notif-->
                      <div class="col-md-3 shownotifmsg animate__animated animate__backInRight" v-if="errorMessage">
                        <div class="col-md-3 alert alert-danger alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ errorMessage }}
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3 shownotifmsg animate__animated animate__backInRight" v-if="successMessage">
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
  
</div>
<script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-profile.js"></script>











