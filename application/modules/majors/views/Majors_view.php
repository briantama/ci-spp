<div id="masterMajors"> 
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
                 <!--  <div class="card-header">
                    <h4></h4>
                  </div> -->
                  <div class="card-body">

                    <div class="float-left">
                       <div class="buttons">
                      <a href="#" @click="showPopupMajors();" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Add</a>
                      <a href="<?php echo base_url(); ?>/majors/viewMajors/print" target="_blank" class="btn btn-icon icon-left btn-secondary"><i class="fa fa-print"></i> print</a>
                      <a href="<?php echo base_url(); ?>/majors/viewMajors/export" target="_blank" class="btn btn-icon icon-left btn-success"><i class="fa fa-file-excel"></i> Excel</a>
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

                          <input type="text" class="form-control" v-model="searchQuery" placeholder="Search MajorName">
                          <div class="input-group-append">
                            <a href="#" class="btn btn-primary"><i class="fas fa-search"></i></a>
                          </div>
                        </div>
                      </form>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">

                      <div v-if="users">
                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                            <th>Action</th>
                            <th>MajorID</th>
                            <th>MajorName</th>
                            <th>Description</th>
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
                            <a data-toggle="modal" data-target="#getmodalMajors"class="btn btn-warning" @click="selectEditMajors(row)" title="Edit"><i class="fa fa-edit"></i> </a> 
                            <a data-toggle="modal" data-target="#getmodalcnfMajor" @click="selectMajors(row);" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i> </a> 
                            </td>
                            <td>{{row.majorid}}</td>
                            <td>{{row.majorname}}</td>
                            <td>{{row.description}}</td>
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
                            <th>MajorID</th>
                            <th>MajorName</th>
                            <th>majorname</th>
                            <th>Description</th>
                            <th>IsActive</th>
                            <th>EntryBy</th>
                            <th>EntryDate</th>
                            <th>LastUpdateBy</th>
                            <th>LastUpdateDate</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan="9" style="text-align: center;">No Record Data</td>
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

  <div class="col-md-3 shownotifmsg" v-if="successMessage">
    <div class="alert alert-success alert-dismissible show animate__animated animate__backInRight">
      <div class="alert-body">
        <button class="close" data-dismiss="alert">
          <span>&times;</span>
        </button>
          <i class="fa fa-check"></i> {{ successMessage }}
      </div>
    </div>
  </div>
<!-- end notif-->


<!-- form class-->
<div class="modal animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="getmodalMajors">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Form Major</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                 <!-- notif-->
                      <div v-if="validateformMajor">
                        <div class="alert alert-danger alert-dismissible show animate__animated animate__shakeY">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ validateformMajor }}
                          </div>
                        </div>
                      </div>
                  <!-- end notif-->

                <form>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td>Class ID *</td>
                        <td>
                         <div v-if="classmajor">
                          <input type="text" ref="majorid" id="majorid" name="majorid" class="form-control" v-model="formMajor.majorid" readonly="{{classmajor}}">
                         </div>
                         <div v-else>
                          <input type="text" ref="majorid" id="majorid" name="majorid" class="form-control" v-model="formMajor.majorid">
                         </div>
                          <!-- status major-->
                          <div v-if="statusMajor"><font color="red"><i style="font-size: 10px;">{{statusMajor}}</i></font></div>
                       </td>
                      </tr>
                       <tr>
                        <td>Major Name *</td>
                        <td><input type="text" ref="majorname" id="majorname" name="majorname" class="form-control" v-model="formMajor.majorname">
                        </td>
                      </tr>
                       <tr>
                        <td>Description</td>
                        <td><textarea id="desc" name="desc" class="form-control" v-model="formMajor.desc"></textarea></td>
                      </tr>
                    </table>
                  </div>
                </form>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="addMajors();"><i class="fa fa-check"></i> Save changes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </div>
        </div>

<!-- form popup delete class-->
<div class="modal animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="getmodalcnfMajor">
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
                    <h3>{{clickedMajor.majorid}} - {{clickedMajor.majorname}}</h3>
                </center>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="deleteMajors();"><i class="fa fa-check"></i> Yes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
              </div>
            </div>
          </div>
        </div>




</div><!-- end call js -->
 <script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-majors.js"></script>