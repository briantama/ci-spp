var base_url    = window.location.origin;
var app = new Vue({

  el: "#setupProfile",
  data: {
    validateformStp: "",
    statusStp: "",
  	errorMessage: "",
  	successMessage: "",
  	setuppf: [],
    searchQuery:'',
  	formStp: {stpid: "0", stptitle: "", stpname: "", stpdesc: "", stpimg: "N"},
  	clickedClass: {},
    file:'',
    uploadedImage:'',
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getSetupProfile();
  },

  methods: {
  	getSetupProfile: function () {
  		axios.get(base_url+'/ci-spp/setupprofile/viewSetupprofile/view')
  		.then(function (response) {
  			//console.log(response);
  				app.setuppf = response.data;
          console.log(response.data);
  			
  		})
  	},

    showPopupStp: function(){
      $("#getmodalstp").modal('show');//show modal form class
      app.formStp   = {stpid: "0", stptitle: "", stpname: "", stpdesc: "", stpimg: "N"};//reset form;
      app.statusStp   = "";//reset status record;
    },


    addStp: function () {
      var stptl = app.formStp.stptitle;
      var stpnm = app.formStp.stpname;
      var stpdc = app.formStp.stpdesc;
      var formData = app.toFormData(app.formStp);

      if(stptl == ""){
        app.validateformStp = "Please Insert Setup Title";
        setTimeout(function () { app.validateformStp = "" }.bind(this), 5000);//set timeout notif
        this.$refs.stptitle.focus();
      }
      else if(stpnm == ""){
        app.validateformStp = "Please Insert Setup Name";
        setTimeout(function () { app.validateformStp = "" }.bind(this), 5000);//set timeout notif
        this.$refs.stpname.focus();
      }
      else if(stpdc == ""){
        app.validateformStp = "Please Insert Setup Description";
        setTimeout(function () { app.validateformStp = "" }.bind(this), 5000);//set timeout notif
        this.$refs.stpdesc.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/setupprofile/viewSetupprofile/save', formData, {
        header:{
         'Content-Type' : 'multipart/form-data'
        }
       }).then(function (response) {
          console.log(response);
         // app.formStp = {stpid: "0", stptitle: "", stpname: "", stpdesc: "", stpimg: "N"};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getSetupProfile();// reload ulang data class
            $("#getmodalstp").modal('hide');//hide modal form class
          } 
          else if (response.data.status == "failed") {
            app.validateformStp = response.data.msg;
            setTimeout(function () { app.validateformStp = "" }.bind(this), 5000);//set timeout notif
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectStp(param) {
      app.clickedClass = param;
    },


    selectEditStp(param) {
      app.formStp.stpid       = param.setupprofileid;
      app.formStp.stptitle    = param.setuptitle;
      app.formStp.stpname     = param.setupname;
      app.formStp.stpdesc     = param.setupdescription;
      app.formStp.stpimg      = param.setupimagedasbor;
      var imageurl            = param.setupimage;

      //check file image exist
        var http = new XMLHttpRequest();
        http.open('HEAD', base_url+'/ci-spp/upload/profile/'+imageurl, false);
        http.send();
           
        console.log(http.status);

        if(http.status != 404){
          var urlimg = '<img alt="image" src="'+base_url+'/ci-spp/upload/profile/'+imageurl+'" width="120" height="120" class="rounded-circle profile-widget-picture">';
          app.uploadedImage        = urlimg;
            
        }
        else{
          app.uploadedImage = '<img alt="image" src="'+base_url+'/ci-spp/upload/profile/default.jpeg" width="220" height="220" class="rounded-circle profile-widget-picture">';
        }

    
    },


    // deleteClass: function () {
    //   var formData = app.toFormData(app.clickedClass);
    //   axios.post(base_url+'/ci-spp/mclass/viewClass/delete', formData)
    //   .then(function (response) {
    //     console.log(response);
    //     app.clickedClass = {};

    //     if (response.data.status == "ok") {
          
    //       app.successMessage = response.data.caption;
    //       app.getAllClass();
    //       setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
    //       $("#getmodalcnfClass").modal('hide');//hide modal form class
          
    //     } else {
    //       console.log(response);
    //       //app.errorMessage = response.data.message;
    //       //setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout notif
    //     }
    //   })
    // },


    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        if(key == "file"){
          app.file = app.$refs.file.files[0];
          form_data.append('file', app.file);
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
        return this.setuppf.filter((row)=>{
          return this.searchQuery.toLowerCase().split(' ').every(v => row.SetupTitle.toLowerCase().includes(v));
        });
      }
      else{
        return this.setuppf;
      }
    
      
    }
  }





});