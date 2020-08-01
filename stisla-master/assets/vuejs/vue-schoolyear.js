var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app = new Vue({

  el: "#masterSchoolyear",
  data: {
    validateformSchoolyear: "",
    statusSchoolyear: "",
  	errorMessage: "",
  	successMessage: "",
  	users: [],
    searchRecord: '10',
    searchQuery:'',
  	formSchoolyear: {schoolyear: year, desc: ""},
  	clickedSchoolyear: {},
  },

  components: {
    vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllSchoolyear();
  },

  methods: {

     //format date
    customFormatter(date) {
      return moment(date).format('YYYY');
    },

  	getAllSchoolyear: function () {
  		axios.get(base_url+'/ci-spp/schoolyear/viewSchoolyear/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.users = response.data;
          console.log(response.data);
  			
  		})
  	},

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/schoolyear/viewSchoolyear/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.users = response.data;
          console.log(response.data);
        
      })
    },

    showPopupSchoolyear: function(){
      $("#getmodalSchoolyear").modal('show');//show modal form class
      app.formSchoolyear   = {schoolyear: year+"-"+months+"-"+date, desc: ""};//reset form;
      //app.classmajor       = "";
      app.statusSchoolyear = "";//reset status record;
    },


    addSchoolyear: function () {
      var cyear    = app.formSchoolyear.schoolyear;
      var formData = app.toFormData(app.formSchoolyear);

      if(cyear == ""){
        app.validateformSchoolyear = "Please Insert School Year";
        setTimeout(function () { app.validateformSchoolyear = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cyaer.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/schoolyear/viewSchoolyear/save', formData)
        .then(function (response) {
          console.log(response);
          app.formSchoolyear = {schoolyear: "", desc: ""};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllSchoolyear();// reload ulang data class
            $("#getmodalSchoolyear").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectSchoolyear(param) {
      app.clickedSchoolyear = param;
    },


    selectEditSchoolyear(param) {
      app.clickedSchoolyear = param;
      app.formSchoolyear.schoolyear     = param.schoolyear;
      app.formSchoolyear.desc           = param.description;
      
      if(param.isactive == "N"){
        app.statusSchoolyear          = "Record Is Deleted";
      }
      else{
        app.statusSchoolyear          = "";
      } 
    },


    deleteSchoolyear: function () {
      var formData = app.toFormData(app.clickedSchoolyear);
      axios.post(base_url+'/ci-spp/schoolyear/viewSchoolyear/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedSchoolyear = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllSchoolyear();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfSchoolyear").modal('hide');//hide modal form class
          
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
        
        if(key == "schoolyear" ){
          form_data.append(key, moment(obj[key]).format('YYYY'));
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
          return this.searchQuery.toLowerCase().split(' ').every(v => row.schoolyear.toLowerCase().includes(v));
        });
      }
      else{
        return this.users;
      }
    
      
    }
  }




});