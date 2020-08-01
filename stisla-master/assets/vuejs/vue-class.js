var base_url    = window.location.origin;
var app = new Vue({

  el: "#masterClass",
  data: {
    validateformClass: "",
    statusClass: "",
    classread: "",
  	errorMessage: "",
  	successMessage: "",
  	users: [],
    searchRecord: '10',
    searchQuery:'',
  	formClass: {classid: "", classname: "", desc: ""},
  	clickedClass: {},
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllClass();
  },

  methods: {
  	getAllClass: function () {
  		axios.get(base_url+'/ci-spp/mclass/viewClass/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.users = response.data;
          console.log(response.data);
  			
  		})
  	},

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/mclass/viewClass/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.users = response.data;
          console.log(response.data);
        
      })
    },

    showPopupClass: function(){
      $("#getmodalClass").modal('show');//show modal form class
      app.formClass   = {classid: "", classname: "", desc: ""};//reset form;
      app.classread   = "";
      app.statusClass = "";//reset status record;
    },


    addClass: function () {
      var clsid = app.formClass.classid;
      var clsnm = app.formClass.classname;
      var formData = app.toFormData(app.formClass);

      if(clsid == ""){
        app.validateformClass = "Please Insert Class ID";
        setTimeout(function () { app.validateformClass = "" }.bind(this), 5000);//set timeout notif
        this.$refs.classid.focus();
      }
      else if(clsnm == ""){
        app.validateformClass = "Please Insert Class Name";
        setTimeout(function () { app.validateformClass = "" }.bind(this), 5000);//set timeout notif
        this.$refs.classname.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/mclass/viewClass/save', formData)
        .then(function (response) {
          console.log(response);
          app.formClass = {classid: "", classname: "", desc: ""};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllClass();// reload ulang data class
            $("#getmodalClass").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectClass(param) {
      app.clickedClass = param;
    },


    selectEditClass(param) {
      app.clickedClass = param;
      app.classread            = "readonly";
      app.formClass.classid    = param.classid;
      app.formClass.classname  = param.classname;
      app.formClass.desc       = param.description;
      
      if(param.isactive == "N"){
        app.statusClass          = "Record Is Deleted";
      }
      else{
        app.statusClass          = "";
      } 
    },


    deleteClass: function () {
      var formData = app.toFormData(app.clickedClass);
      axios.post(base_url+'/ci-spp/mclass/viewClass/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedClass = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllClass();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfClass").modal('hide');//hide modal form class
          
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
          return this.searchQuery.toLowerCase().split(' ').every(v => row.classname.toLowerCase().includes(v));
        });
      }
      else{
        return this.users;
      }
    
      
    }
  }




});