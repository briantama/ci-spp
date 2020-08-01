<div id="masterStudent"> 
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

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <!-- <div class="card-header">
                    <h4></h4>
                    <
                  </div> -->
                  <div class="card-body">

                    <div class="float-left">
                       <div class="buttons">
                      <a href="#" @click="showPopupStudent();" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus"></i> Add</a>
                      <a href="<?php echo base_url(); ?>/student/viewStudent/print" target="_blank" class="btn btn-icon icon-left btn-secondary"><i class="fa fa-print"></i> print</a>
                      <a href="<?php echo base_url(); ?>/student/viewStudent/export" class="btn btn-icon icon-left btn-success"><i class="fa fa-file-excel"></i> Excel</a>
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

                          <input type="text" id="searchQuery" class="form-control" v-model="searchQuery" placeholder="Search StudentName">
                          <div class="input-group-append">
                            <a href="#" class="btn btn-primary"><i class="fas fa-search"></i></a>
                          </div>
                        </div>
                      </form>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">

                      <div v-if="student">
                      <table class="table table-striped" id="sortable-table">
                        <thead>
                          <tr>
                            <th>Action</th>
                            <th>StudentID</th>
                            <th>StudentName</th>
                            <th>Schoolyear</th>
                            <th>classID</th>
                            <th>MajorID</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>DateOfBirth</th>
                            <th>JoinDate</th>
                            <th>Adress</th>
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
                            <a data-toggle="modal" data-target="#getmodalStudent"class="btn btn-warning" @click="selectEditStudent(row)" title="Edit"><i class="fa fa-edit"></i> </a> 
                            <a data-toggle="modal" data-target="#getmodalcnfStudent" @click="selectStudent(row);" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i> </a> 
                            </td>
                            <td>{{row.studentid}}</td>
                            <td>{{row.studentname}}</td>
                            <td>{{row.schoolyear}}</td>
                            <td>{{row.classid}}</td>
                            <td>{{row.majorid}}</td>
                            <td>{{row.gender}}</td>
                            <td>{{row.email}}</td>
                            <td>{{row.dateofbirth}}</td>
                            <td>{{row.joindate}}</td>
                            <td>{{row.adress}}</td>
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
                            <th>StudentID</th>
                            <th>StudentName</th>
                            <th>Schoolyear</th>
                            <th>classID</th>
                            <th>MajorID</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>DateOfBirth</th>
                            <th>JoinDate</th>
                            <th>Adress</th>
                            <th>IsActive</th>
                            <th>EntryBy</th>
                            <th>EntryDate</th>
                            <th>LastUpdateBy</th>
                            <th>LastUpdateDate</th>
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
<div class="modal animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="getmodalStudent">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Form Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                 <!-- notif-->
                      <div v-if="validateformStudent">
                        <div class="alert alert-danger alert-dismissible show animate__animated animate__shakeY">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            <i class="fa fa-times"></i> {{ validateformStudent }}
                          </div>
                        </div>
                      </div>
                  <!-- end notif-->

                <form>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td>StudentID *{{studentread}}</td>
                        <td>
                         <div v-if="studentread">
                           <input type="text" ref="studentid" id="studentid`" name="studentid" class="form-control" v-model="formStudent.studentid" readonly="{{studentread}}">
                         </div>
                          <div v-else>
                           <input type="text" ref="studentid" id="studentid`" name="studentid" class="form-control" v-model="formStudent.studentid">
                         </div>
                          <!-- status class-->
                          <div v-if="statusStudent"><font color="red"><i style="font-size: 10px;">{{statusStudent}}</i></font></div>
                        </td>
                          <td>StudentName *</td>
                        <td><input type="text" ref="studentname" id="studentname`" name="studentname" class="form-control" v-model="formStudent.studentname">
                        </td>
                      </tr>
                       <tr>
                        <td>Class ID *</td>
                        <td><input type="text" ref="classid" id="classid" name="classid" class="form-control" v-model= formStudent.classid @keyup="getData()" autocomplete="off">
                        <!-- show search -->
                           <div class="panel-footer" v-if="search_data.length">
                            <ul class="list-group">
                              <a href="#" class="list-group-item" v-for="data1 in search_data" @click="getName(data1.keyclassid)">{{ data1.classid }}</a>
                            </ul>
                          </div>
                        </td>
                        <td>Gender *</td>
                        <td>
                          <select ref="gender" id="gender" name="gender" class="form-control" v-model="formStudent.gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>

                         </td>
                      </tr>
                      <tr>
                        <td>Email *</td>
                        <td><input type="text" ref="email" id="email" name="email" class="form-control" v-model="formStudent.email"></td>
                        <td>Date Of Birth *</td>
                        <td>
                         <vuejs-datepicker style="position: inherit;" :bootstrap-styling="true" :format="customFormatter" ref="dateof" id="dateof" name="dateof" v-model="formStudent.dateof"></vuejs-datepicker>
                         <!--<input type="text" ref="dateof" id="dateof" name="dateof" class="form-control" v-model="formStudent.dateof">--></td>
                      </tr>
                       <tr>
                        <td>Join Date *</td>
                        <td>
                         <vuejs-datepicker style="position: inherit;" :bootstrap-styling="true" :format="customFormatter" ref="joindate" id="joindate" name="joindate" v-model="formStudent.joindate"></vuejs-datepicker>
                         <!--<input type="text" ref="joindate" id="joindate" name="joindate" class="form-control" v-model="formStudent.joindate">-->
                        </td>
                        <td>Adress</td>
                        <td><textarea id="adress" ref="adress" name="adress" class="form-control" v-model="formStudent.adress"></textarea></td>
                      </tr>
                      <tr>
                        <td>School Year</td>
                        <td>
                          <select ref="periodyear" id="periodyear" name="periodyear" class="form-control" v-model="formStudent.periodyear">
                            <option v-for="scperiod in periods" :value="scperiod.schoolyear">{{scperiod.schoolyear}}</option>
                          </select>
                        </td>
                        <td>Major ID *</td>
                        <td><input type="text" ref="majorid" id="majorid`" name="majorid" class="form-control" v-model="formStudent.majorid" @keyup="getDataMajor()" autocomplete="off">
                          <!-- show search -->
                           <div class="panel-footer" v-if="search_datas.length">
                            <ul class="list-group">
                              <a href="#" class="list-group-item" v-for="data in search_datas" @click="getNameMajor(data.keymajor)">{{ data.majorid }}</a>
                            </ul>
                          </div>

                        </td>
                      </tr>
                      <tr>
                      <td>Upoad Image</td>
                      <td> <input type="file" ref="file" v-model="formStudent.file" class="form-control"/></td>
                      <td colspan="2"> <div v-html="uploadedImage" align="center"></div></td>  
                      </tr>
                    </table>
                  </div>
                </form>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="addStudent();"><i class="fa fa-check"></i> Save changes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </div>
        </div>

<!-- form popup delete class-->
<div class="modal animate__animated animate__jackInTheBox" tabindex="-1" role="dialog" id="getmodalcnfStudent">
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
                    <h3>{{clickedStudent.studentid}}</h3>
                </center>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" @click="deleteStudent();"><i class="fa fa-check"></i> Yes</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
              </div>
            </div>
          </div>
        </div>




</div><!-- end call js -->
<style>
 .posty{
  display: flex;
  position: fixed;
 }
</style>
 <script src="<?php echo base_url(); ?>stisla-master/assets/vuejs/vue-student.js"></script>
 <script>
  // $('#dateof').datepicker({
  //  format: "yyyy-mm-dd",
  //  todayHighlight: true,
  //  orientation: "bottom auto",
  //  autoclose:true
  //});
  // 
  // $('#joindate').datepicker({
  //  format: "yyyy-mm-dd",
  //  todayHighlight: true,
  //  orientation: "bottom auto",
  //  autoclose:true
  //});
 </script>
 