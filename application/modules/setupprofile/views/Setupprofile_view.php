<div id="setupProfile"> 
 <div class="main-content animate__animated animate__bounceInLeft">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $title; ?> </h1>

            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Components</a></div>
              <div class="breadcrumb-item">Table</div>
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

                      <div class="buttons">
                      <a v-if="!setuppf" href="#" @click="showPopupStp();" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Add</a>
                      <!-- <a href="#" class="btn btn-icon icon-left btn-success"><i class="fa fa-print"></i> print</a> -->
                      </div>
                    </h4>
                    <div class="card-header-action">
                      <form>
                        <div class="input-group">
                          <input type="text" class="form-control" v-model="searchQuery" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <div v-if="setuppf">
                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                            <th>Action</th>
                            <th>SetupprofileID</th>
                            <th>SetupTitle</th>
                            <th>SetupName</th>
                            <th>SetupDescription</th>
                            <th>SetupImageDasbor</th>
                            <th>SetupImage</th>
                            <th>setupLogo</th>
                            <th>IsActive</th>
                            <th>EntryBy</th>
                            <th>EntryDate</th>
                            <th>LastUpdateBy</th>
                            <th>LastUpdateDate</th>
                          </tr>
                        </thead>
                        <tbody>

                          <tr v-for="row in filteredResources">
                            <td nowrap> 
                            <a data-toggle="modal" data-target="#getmodalstp"class="btn btn-warning" @click="selectEditStp(row)" title="Edit"><i class="fa fa-edit"></i> </a> 
                            </td>
                            <td>{{row.setupprofileid}}</td>
                            <td>{{row.setuptitle}}</td>
                            <td>{{row.setupname}}</td>
                            <td>{{row.setupdescription}}</td>
                            <td>{{row.setupimagedasbor}}</td>
                            <td>{{row.setupimage}}</td>
                            <td>{{row.setuplogo}}</td>
                            <td>{{row.isactive}}</td>
                            <td>{{row.entryby}}</td>
                            <td>{{row.entrydate}}</td>
                            <td>{{row.lastupdateby}}</td>
                            <td>{{row.lastupdatedate}}</td>
                          </tr>
                        </tbody>
                      </table>
                        </div>

                        <div v-else>
                        <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                            <th>Action</th>
                            <th>SetupprofileID</th>
                            <th>SetupTitle</th>
                            <th>SetupName</th>
                            <th>SetupDescription</th>
                            <th>SetupImageDasbor</th>
                            <th>SetupImage</th>
                            <th>setupLogo</th>
                            <th>IsActive</th>
                            <th>EntryBy</th>
                            <th>EntryDate</th>
                            <th>LastUpdateBy</th>
                            <th>LastUpdateDate</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan="13" style="text-align: center;">No Record Data</td>
                          </tr>
                        </tbody>
                        </table>
                        </div>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
           
          </div>
        </section>
      </div>


<!-- form class-->
<div class="modal animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="getmodalstp">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Form Setup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

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

                <form>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <input type="hidden" ref="stpid" id="stpid" name="stpid" class="form-control" v-model="formStp.stpid">
                   
                      <tr>
                        <td>Setup Title *</td>
                        <td><input type="text" ref="stptitle" id="stptitle" name="stptitle" class="form-control" v-model="formStp.stptitle">
                          <!-- status class-->
                          <div v-if="statusStp"><font color="red"><i style="font-size: 10px;">{{statusStp}}</i></font></div>
                        </td>
                        <td>Setup Name *</td>
                        <td><input type="text" ref="stpname" id="stpname" name="stpname" class="form-control" v-model="formStp.stpname"></td>
                      </tr>
                      <tr>
                       <td>Setup Description</td>
                        <td><textarea id="stpdesc" name="stpdesc" class="form-control" v-model="formStp.stpdesc"></textarea></td>
                        <td>Setup Show Image *</td>
                        <td>
                          <select ref="stpname" id="stpimg" name="stpimg" class="form-control" v-model="formStp.stpimg">
                            <option value="N">No</option>
                            <option value="Y">Yes</option>
                          </select>
                        </td>
                      </tr>

                       <tr>
                      <td>Upoad Image</td>
                      <td> <input type="file" ref="file" v-model="formStp.file" class="form-control"/></td>
                      <td colspan="2"> <div v-html="uploadedImage" align="center"></div></td>  
                      </tr>
                    </table>
                  </div>
                </form>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="addStp();"><i class="fa fa-check"></i> Save changes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </div>
        </div>

<!-- form popup delete class-->
<!-- <div class="modal fade" tabindex="-1" role="dialog" id="getmodalcnfClass">
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
                    <h3>{{clickedClass.ClassID}}</h3>
                </center>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="deleteClass();"><i class="fa fa-check"></i> Yes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
              </div>
            </div>
          </div>
        </div> -->




</div><!-- end call js -->
 <script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-setup.js"></script>