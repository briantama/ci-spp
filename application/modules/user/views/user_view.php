<div id="masterUser"> 
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

            <!-- <h2 class="section-title">Table</h2>
            <p class="section-lead">Example of some Bootstrap table components.</p> -->

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <!-- <div class="card-header">
                    <h4></h4>
                  </div> -->
                  <div class="card-body">

                    <div class="float-left">
                      <div class="buttons">
                      <?php if(trim($this->session->userdata('superuser')) == "Y"){ ?>
                      <a href="#" @click="showPopupUser();" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Add</a>
                      <?php } ?>
                      </div>
                    </div>

                      <div class="float-right">
                      <form>
                        <div class="input-group">

                           <select class="form-control" id="searchRecord" name="searchRecord" v-model="searchRecord" @change="selectRecord();">
                            <option value="10">10 Record</option>
                            <option value="50">50 Record</option>
                            <option value="100">100 Record</option>
                            <option value="500">500 Record</option>
                            <option value="ALL">All</option>
                          </select>

                        <div>&nbsp;</div>

                          <input type="text" id="searchQuery" class="form-control" v-model="searchQuery" placeholder="Search AdminName">
                          <div class="input-group-append">
                            <a href="#" class="btn btn-primary"><i class="fas fa-search"></i></a>
                          </div>
                        </div>
                      </form>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div v-if="users">
                    <div class="table-responsive">
                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                            <th>Edit</th>
                            <th>AdminID</th>
                            <th>AdminName</th>
                            <th>DateOfBirth</th>
                            <th>UserName</th>
                            <th>email</th>
                            <th>SuperUser</th>
                            <th>IsActive</th>
                            <th>EntryDate</th>
                            <th>EntryBy</th>
                            <th>LastUpdateDate</th>
                            <th>LastUpdateBy</th>
                          </tr>
                        </thead>
                        <tbody>

                          <tr v-for="row in filteredResources">
                            <td nowrap> 
                            <a data-toggle="modal" data-target="#getmodalUser"class="btn btn-warning" @click="selectEditUser(row)" title="Edit"><i class="fa fa-edit"></i> </a> 
                            <a data-toggle="modal" data-target="#getmodalcnfUser" @click="selectUser(row);" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i> </a> 
                            </td>
                            <td>{{row.adminid}}</td>
                            <td>{{row.adminname}}</td>
                            <td>{{row.dateofbirth}}</td>
                            <td>{{row.usernme}}</td>
                            <td>{{row.email}}</td>
                            <td>{{row.superuser}}</td>
                            <td>{{row.isactive}}</td>
                            <td>{{row.entryby}}</td>
                            <td>{{row.entrydate}}</td>
                            <td>{{row.lastupdateby}}</td>
                            <td>{{row.lastupdatedate}}</td>
                          </tr>
                        </tbody>
                        </table>
                        </div>
                       </div>

                        <div v-else>
                          <div class="table-responsive">
                          <table class="table table-striped" id="sortable-table">
                          <thead>
                            <tr>
                              <th>Edit</th>
                              <th>AdminID</th>
                              <th>AdminName</th>
                              <th>DateOfBirth</th>
                              <th>UserName</th>
                              <th>email</th>
                              <th>SuperUser</th>
                              <th>IsActive</th>
                              <th>EntryDate</th>
                              <th>EntryBy</th>
                              <th>LastUpdateDate</th>
                              <th>LastUpdateBy</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="8" style="text-align: center;">No Record Data</td>
                            </tr>
                        </tbody>
                      </table>
                       </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>
          
           
          </div>
        </section>
      </div>


<!-- form class-->
<div class="modal animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="getmodalUser">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Form User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                 <!-- notif-->
                      <div v-if="validateformUser">
                        <div class="alert alert-danger alert-dismissible show animate__animated animate__shakeY">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ validateformUser }}
                          </div>
                        </div>
                      </div>
                  <!-- end notif-->

                <form>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <input type="hidden" ref="idadminx" id="idadminx" name="idadminx" class="form-control" v-model="formUser.idadminx">
                      <tr>
                        <td>Admin Name *</td>
                        <td><input type="text" ref="adminname" id="adminname" name="adminname" class="form-control" v-model="formUser.adminname">
                          <!-- status class-->
                          <div v-if="statusUser"><font color="red"><i style="font-size: 10px;">{{statusUser}}</i></font></div>
                        </td>
                      </tr>
                      <tr>
                        <td>Email *</td>
                        <td><input type="text" ref="email" id="email" name="email" class="form-control" v-model="formUser.email"></td>
                      </tr>
                       <tr>
                        <td>DateOfBirth *</td>
                        <td>
                         <vuejs-datepicker style="position: inherit;" :bootstrap-styling="true" :format="customFormatter" ref="date_of" id="date_of" name="date_of" v-model="formUser.date_of"></vuejs-datepicker>
                         <!--<input type="text" ref="date_of" id="date_of" name="date_of" class="form-control" v-model="formUser.date_of">-->
                        </td>
                      </tr>
                      <tr>
                        <td>UserName *</td>
                        <td>
                         <div v-if="userread">
                          <input type="text" ref="username" id="username" name="username" class="form-control" v-model="formUser.username" readonly="readonly">
                         </div>
                         <div v-else>
                          <input type="text" ref="username" id="username" name="username" class="form-control" v-model="formUser.username">
                         </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Password *</td>
                        <td><input type="password" ref="password" id="password" name="password" class="form-control" v-model="formUser.password"></td>
                      </tr>
                      <tr>
                        <td>Re Password *</td>
                        <td><input type="password" ref="repassword" id="repassword" name="repassword" class="form-control" v-model="formUser.repassword"></td>
                      </tr>
                      <tr>
                        <td>Super User *</td>
                        <td>
                          <select name="supuser" id="supuser" ref="supuser" v-model="formUser.supuser" class="form-control">
                            <option value="N">No</option>
                            <?php if(trim($this->session->userdata('superuser')) == "Y"){ ?>
                            <option value="Y">Yes</option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                    </table>  
                  </div>
                </form>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="addUsers();"><i class="fa fa-check"></i> Save changes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </div>
        </div>

<!-- form popup delete class-->
<div class="modal modal animate__animated animate__flipInX" tabindex="-1" role="dialog" id="getmodalcnfUser">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Really ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <center>
                    <p>Are you sure you want to delete?</p>
                    <h3>{{clickedUser.username}}</h3>
                </center>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="deleteClass();"><i class="fa fa-check"></i> Yes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
              </div>
            </div>
          </div>
        </div>




</div><!-- end call js -->
<script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-users.js"></script>