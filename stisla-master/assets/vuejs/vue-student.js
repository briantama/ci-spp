var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app = new Vue({

  el: "#masterStudent",
  data: {
    validateformStudent: "",
    statusStudent: "",
    studentread: "",
  	errorMessage: "",
  	successMessage: "",
  	student: [],
    periods:[],
    searchRecord: '10',
    searchQuery:'',
  	formStudent: {classid: '', joindate: '', dateof: '', periodyear: year, majorid: ''},
  	clickedStudent: {},
    query:'',
    search_data:[],
    query1:'',
    search_datas:[],
    uploadedImage:'',
  },
  
  components: {
  	vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllStudent();
    this.getAllPeriod();
  },

  methods: {
    
    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },
    
    //autocomplete
    getData:function(){
      this.search_data = [];
      axios.post(base_url+'/ci-spp/student/viewStudent/searchclass', {
        query:this.formStudent.classid
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getName:function(name){
      this.formStudent.classid  = name;
      this.search_data          = [];
      this.$refs.gender.focus();
    },

    //autocomplete major
    getDataMajor:function(){

      this.search_datas = [];
      axios.post(base_url+'/ci-spp/student/viewStudent/searchmajor', {
        query1: this.formStudent.majorid
      }).then(response => {
        this.search_datas = response.data;
      });
    },
    
    getNameMajor:function(name){
      this.formStudent.majorid   = name;
      this.search_datas = [];
    },
    
    
  	getAllStudent: function () {
  		axios.get(base_url+'/ci-spp/student/viewStudent/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.student = response.data;
          console.log(response.data);
  			
  		});
  	},

    //show period
    getAllPeriod: function () {
      axios.get(base_url+'/ci-spp/student/viewStudent/viewperiod')
      .then(function (response) {
        //console.log(response);
          app.periods = response.data;
          //console.log(response.data);
        
      });
    },

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/student/viewStudent/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.student = response.data;
          console.log(response.data);
        
      })
    },
    

    showPopupStudent: function(){
      $("#getmodalStudent").modal('show');//show modal form class
      app.formStudent              = {};//reset form;
      app.studentread              = "";//disable readonly input student
      app.formStudent.studentid    = "";
      app.formStudent.classid      = "";
      app.formStudent.studentname  = "";
      app.formStudent.dateof       = year+"-"+months+"-"+date;
      app.formStudent.email        = "";
      app.formStudent.adress       = "";
      app.formStudent.joindate     = year+"-"+months+"-"+date;
      app.formStudent.periodyear   = year;
      app.formStudent.gender       = "Male";
      app.statusStudent            = "";//reset status record;
      app.uploadedImage            = '';
    },


    addStudent: function () {
       var studentx = app.formStudent.studentid;
       var classx   = app.formStudent.classid;
       var studentnm= app.formStudent.studentname;
       var dateofx  = app.formStudent.dateof;
       var emailx   = app.formStudent.email;
       var adressx  = app.formStudent.adress;
       var joindatex= app.formStudent.joindate;
       var periodx  = app.formStudent.periodyear;
        
      //convert datetime
      //var condtx = moment(dateofx).format('YYYY-MM-DD');
       
       var formData = app.toFormData(app.formStudent);
      // var obj      = app.formStudent;
      // for (var key in obj) {
      // 
      //  else{
      //    var xx = obj[key];
      //    alert(xx);
      //  }
      //  
      //}
       
       //alert("okeee "+app.formStudent);

       if(studentx == ""){
         app.validateformStudent = "Please Insert Student ID";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.studentid.focus();
       }
       else if(classx == ""){
         app.validateformStudent = "Please Insert Class ID";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.classid.focus();
       }
       else if(studentnm == ""){
         app.validateformStudent = "Please Insert Student Name";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.studentname.focus();
       }
       else if(dateofx == ""){
         app.validateformStudent = "Please Insert Date Of Birth";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.dateof.focus();
       }
       else if(emailx == ""){
         app.validateformStudent = "Please Insert Email";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.email.focus();
       }
       else if(adressx == ""){
         app.validateformStudent = "Please Insert Adress";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.adress.focus();
       }
       else if(joindatex == ""){
         app.validateformStudent = "Please Insert Join Date";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.joindate.focus();
       }
       else if(periodx == ""){
         app.validateformStudent = "Please Insert School Year";
         setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
         this.$refs.periodyear.focus();
       }
       else{
      
        axios.post(base_url+'/ci-spp/student/viewStudent/save', formData, {
        header:{
         'Content-Type' : 'multipart/form-data'
        }
        }).then(function (response) {
          console.log(response);

          if (response.data.status == "ok") {
            app.formStudent = {};
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = ""; }.bind(this), 5000);//set timeout notif
            app.getAllStudent();// reload ulang data class
            $("#getmodalStudent").modal('hide');//hide modal form class
          } 
          else {
            app.validateformStudent = response.data.msg;
            setTimeout(function () { app.validateformStudent = ""; }.bind(this), 5000);//set timeout notif
            var formfocus = response.data.focus;
            this.$refs.formfocus.focus();
            console.log(response);
          }

        });

      }

    },


    selectStudent(param) {
      app.clickedStudent = param;
    },

  
    selectEditStudent(param) {
      app.clickedStudent = param;
      app.studentread              = "readonly";//disable readonly input student
      app.formStudent.studentid    = param.studentid;
      app.formStudent.classid      = param.classid;
      app.formStudent.studentname  = param.studentname;
      app.formStudent.gender       = param.gender;
      app.formStudent.dateof       = param.dateofbirth;
      app.formStudent.email        = param.email;
      app.formStudent.adress       = param.adress;
      app.formStudent.joindate     = param.joindate;
      app.formStudent.periodyear   = param.schoolyear;
      app.formStudent.majorid      = param.majorid;
      var imageurl                 = param.studentimage;

      if(param.isactive == "N"){
        app.statusStudent          = "Record Is Deleted";
      }
      else{
        app.statusStudent          = "";
      } 

       //check file image exist
        var http = new XMLHttpRequest();
        http.open('HEAD', base_url+'/ci-spp/upload/student/'+imageurl, false);
        http.send();
           
        console.log(http.status);

        if(http.status != 404){
          var urlimg = '<img alt="image" src="'+base_url+'/ci-spp/upload/student/'+imageurl+'" width="120" height="120" class="rounded-circle profile-widget-picture">';
          app.uploadedImage        = urlimg;
            
        }
        else{
          app.uploadedImage = '<img alt="image" src="'+base_url+'/ci-spp/upload/student/default.jpeg" width="220" height="220" class="rounded-circle profile-widget-picture">';
        }


    },


    deleteStudent: function () {
      var formData = app.toFormData(app.clickedStudent);
      axios.post(base_url+'/ci-spp/student/viewStudent/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedStudent = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllStudent();
          setTimeout(function () { app.successMessage = ""; }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfStudent").modal('hide');//hide modal form class
          
        } else {
          console.log(response);
          //app.errorMessage = response.data.message;
          //setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout notif
        }
      });
    },


    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        if(key == "file"){
          app.file = app.$refs.file.files[0];
          form_data.append('file', app.file);
        }
        else if(key == "dateof" || key == "joindate"){
          form_data.append(key, moment(obj[key]).format('YYYY-MM-DD'));
        }
        else{
           form_data.append(key, obj[key]);
        }
       
      }
      return form_data;
    }

  },

  computed: {
    filteredResources (){
      //if(this.searchQuery){
      // return this.student.filter((row)=>{
      //   return row.StudentName.toLowerCase().startsWith(this.searchQuery.toLowerCase());
      // })

      if(this.searchQuery){
        //var idxxx = $('#searchQuery').val();
        //alert(idxxx);
        return this.student.filter((row)=>{
          return this.searchQuery.toLowerCase().split(' ').every(v => row.studentname.toLowerCase().includes(v));
        });
      }
      else{
        return this.student;
      }
      
    }
  }




});