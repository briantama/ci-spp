var base_url    = window.location.origin;
var app = new Vue({

  el: "#masterMajors",
  data: {
    validateformMajor: "",
    statusMajor: "",
    classmajor: "",
  	errorMessage: "",
  	successMessage: "",
  	users: [],
    searchRecord: '10',
    searchQuery:'',
  	formMajor: {majorid: "",majorname: "", desc: ""},
  	clickedMajor: {},
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllMajors();
  },

  methods: {
  	getAllMajors: function () {
  		axios.get(base_url+'/ci-spp/majors/viewMajors/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.users = response.data;
          console.log(response.data);
  			
  		})
  	},

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/majors/viewMajors/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.users = response.data;
          console.log(response.data);
        
      })
    },

    showPopupMajors: function(){
      $("#getmodalMajors").modal('show');//show modal form class
      app.formMajor   = {majorid: "", majorname: "", desc: ""};//reset form;
      app.classmajor   = "";
      app.statusMajor = "";//reset status record;
    },


    addMajors: function () {
      var clsid = app.formMajor.majorid;
      var clsnm = app.formMajor.majorname;
      var formData = app.toFormData(app.formMajor);

      if(clsid == ""){
        app.validateformMajor = "Please Insert Major ID";
        setTimeout(function () { app.validateformMajor = "" }.bind(this), 5000);//set timeout notif
        this.$refs.majorid.focus();
      }
      else if(clsnm == ""){
        app.validateformMajor = "Please Insert Major Name";
        setTimeout(function () { app.validateformMajor = "" }.bind(this), 5000);//set timeout notif
        this.$refs.majorname.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/majors/viewMajors/save', formData)
        .then(function (response) {
          console.log(response);
          app.formMajor = {majorid: "", majorname: "", desc: ""};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllMajors();// reload ulang data class
            $("#getmodalMajors").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectMajors(param) {
      app.clickedMajor = param;
    },


    selectEditMajors(param) {
      app.clickedMajor = param;
      app.classmajor            = "readonly";
      app.formMajor.majorid    = param.majorid;
      app.formMajor.majorname  = param.majorname;
      app.formMajor.desc       = param.description;
      
      if(param.isactive == "N"){
        app.statusMajor          = "Record Is Deleted";
      }
      else{
        app.statusMajor          = "";
      } 
    },


    deleteMajors: function () {
      var formData = app.toFormData(app.clickedMajor);
      axios.post(base_url+'/ci-spp/majors/viewMajors/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedMajor = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllMajors();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfMajor").modal('hide');//hide modal form class
          
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
        form_data.append(key, obj[key]);
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
          return this.searchQuery.toLowerCase().split(' ').every(v => row.majorname.toLowerCase().includes(v));
        });
      }
      else{
        return this.users;
      }
    
      
    }
  }




});