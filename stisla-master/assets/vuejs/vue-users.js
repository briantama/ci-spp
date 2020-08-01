var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app = new Vue({

  el: "#masterUser",
  data: {
    validateformUser: "",
    statusUser: "",
  	errorMessage: "",
  	successMessage: "",
  	users: [],
    searchRecord: '10',
    searchQuery:'',
    userread: '',
  	formUser: {supuser: "N", idadminx: '0', adminname: '', date_of: '', email: '', username: '', password: '', repassword: ''},
  	clickedUser: {},
  },
  
  components: {
  	vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllUser();
  },

  methods: {
    
    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },
    
    
  	getAllUser: function () {
  		axios.get(base_url+'/ci-spp/user/viewUser/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.users = response.data;
          console.log(response.data);
  			
  		});
  	},

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/user/viewUser/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.users = response.data;
          console.log(response.data);
        
      })
    },


    showPopupUser: function(){
      $("#getmodalUser").modal('show');//show modal form class
      this.$refs.adminname.focus();
      app.userread   = '';
      app.formUser   = {supuser: "N", idadminx: '0', adminname: '', date_of: year+'-'+months+'-'+date, email: '', username: '', password: '', repassword: ''};//reset form;
      app.statusUser = "";//reset status record;
    },


    addUsers: function () {
      var adminx = app.formUser.adminname;
      var dateofx= app.formUser.date_of;
      var emailx = app.formUser.email;
      var userx  = app.formUser.username;
      var emailx = app.formUser.email;
      var pswdx  = app.formUser.password;
      var repswdx= app.formUser.repassword;
      
      var formData = app.toFormData(app.formUser);

      if(adminx == ""){
        app.validateformUser = "Please Insert Admin Name";
        setTimeout(function () { app.validateformUser = "" }.bind(this), 5000);//set timeout notif
        this.$refs.adminname.focus();
      }
      else if(emailx == ""){
        app.validateformUser = "Please Insert Email";
        setTimeout(function () { app.validateformUser = "" }.bind(this), 5000);//set timeout notif
        this.$refs.email.focus();
      }
      else if(dateofx == ""){
        app.validateformUser = "Please Insert DateOfBirth";
        setTimeout(function () { app.validateformUser = "" }.bind(this), 5000);//set timeout notif
        this.$refs.date_of.focus();
      }
       else if(userx == ""){
        app.validateformUser = "Please Insert UserName";
        setTimeout(function () { app.validateformUser = "" }.bind(this), 5000);//set timeout notif
        this.$refs.username.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/user/viewUser/save', formData)
        .then(function (response) {
          console.log(response);
          
          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllUser();// reload ulang data class
            $("#getmodalUser").modal('hide');//hide modal form class
            app.formUser = {supuser: "N", idadmin: 0, adminname: '', date_of: '', email: '', username: '', password: '', repassword: ''};
          }
          else if (response.data.status == "failed") {
            app.validateformUser = response.data.msg;
            setTimeout(function () { app.validateformUser = "" }.bind(this), 5000);//set timeout notif
            //var inpfocus         = response.data.focus;
            //this.$refs.inpfocus.focus();
            //app.formUser.inpfocus= "";
            setTimeout(function () { app.validateformUser = "" }.bind(this), 5000);//set timeout notif
          } 
          else {
            console.log(response);
          }
        
        });

      }

    },


    selectUser(param) {
      app.clickedUser = param;
    },
    
    
    selectEditUser(param) {
      app.clickedUser = param;
      app.userread    = "readonly";
      app.formUser.idadminx   = param.adminid;
      app.formUser.adminname  = param.adminname;
      app.formUser.email      = param.email;
      app.formUser.date_of    = param.dateofbirth;
      app.formUser.username   = param.username;
      app.formUser.supuser    = param.superuser;
      this.$refs.adminname.focus();
      
      if(param.IsActive == "N"){
        app.statusUser          = "Record Is Deleted";
      }
      else{
        app.statusUser          = "";
      } 
    },
    
    
    deleteUser: function () {
      var formData = app.toFormData(app.clickedUser);
      axios.post(base_url+'/ci-spp/user/viewUser/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedUser = {};
    
        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllClass();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfUser").modal('hide');//hide modal form class
          
        } else {
          console.log(response);
          //app.errorMessage = response.data.message;
          //setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout notif
        }
      })
    },


    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        if(key == "date_of"){
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
      
      if(this.searchQuery){
        //var idxxx = $('#searchQuery').val();
        //alert(idxxx);
        return this.users.filter((row)=>{
          return this.searchQuery.toLowerCase().split(' ').every(v => row.adminname.toLowerCase().includes(v));
        });
      }
      else{
        return this.users;
      }
      
    }
  }




});