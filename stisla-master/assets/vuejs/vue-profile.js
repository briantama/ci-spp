var base_url    = window.location.origin;
var app         = new Vue({
  el: "#vueProfile",
  data: {
    errorMessage: "",
  	successMessage: "",
    profile: [],
    formProfile: {},
    file:'',
    imagefile: '',
    validateformProfile: '',
    uploadedImage:'<img alt="image" src="'+base_url+'/ci-spp/upload/user/default.jpeg" class="rounded-circle profile-widget-picture">',
  },

  components: {
    vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllProfile();
  },

  methods: {

    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },

  	getAllProfile: function () {
  		axios.get(base_url+'/ci-spp/profile/viewProfile/view')
  		.then(function (response) {
  			//console.log(response);
  				app.profile = response.data;
          console.log(response.data);

          var obj = response.data;
          for (var key in obj) {
            //if(obj[key].AdminImage == "AdminImage"){
              var imageurl = obj[key].adminimage;

              var idxadmin = obj[key].adminid;
              var idxadmnm = obj[key].adminname;
              var dateof   = obj[key].dateofbirth;
              var emailx   = obj[key].email;
              var spuser   = obj[key].superuser;
            //}
          }

            //check file image exist
            var http   = new XMLHttpRequest();
            var cekimg = (imageurl != "") ? imageurl : "default.jpeg";
            http.open('HEAD', base_url+'/ci-spp/upload/user/'+cekimg, false);
            http.send();
           
            console.log(cekimg);

          if(http.status != 404){
            var urlimg = '<img alt="image" src="'+base_url+'/ci-spp/upload/user/'+cekimg+'" class="rounded-circle profile-widget-picture">';
            app.uploadedImage        = urlimg;
            app.formProfile.idxadmin = idxadmin; 
            app.formProfile.namex    = idxadmnm;
            app.formProfile.emailx   = emailx;
            app.formProfile.dateofx  = dateof;  
            app.formProfile.supuserx = spuser;  
          }
          else{
            app.uploadedImage = '<img alt="image" src="'+base_url+'/ci-spp/upload/user/default.jpeg" class="rounded-circle profile-widget-picture">';
            app.uploadedImage        = urlimg;
            app.formProfile.idxadmin = idxadmin; 
            app.formProfile.namex    = idxadmnm;
            app.formProfile.emailx   = emailx;
            app.formProfile.dateofx  = dateof; 
            app.formProfile.supuserx = spuser;  
          }

  			
  		})
  	},


    uploadImage:function(){

       app.file = app.$refs.file.files[0];

       var formData = new FormData();

       formData.append('file', app.file);

       axios.post(base_url+'/ci-spp/profile/viewProfile/save', formData, {
        header:{
         'Content-Type' : 'multipart/form-data'
        }
       }).then(function(response){
        if(response.data.status != 'ok')
        {

         app.errorMessage       = response.data.msg;
         setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
         //app.uploadedImage = '';

        }
        else
        {

         app.successMessage     = response.data.msg;
         setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
         var urlimg             = '<img alt="image" src="'+base_url+'/ci-spp/upload/user/'+response.data.filenm+'" class="rounded-circle profile-widget-picture">';
         app.uploadedImage      = urlimg;
         app.$refs.file.value   = '';

        }

       });
    },


    updateProfile: function () {
      var pfnamex  = app.formProfile.namex;
      var pfemail  = app.formProfile.emailx;
      var pfdateof = app.formProfile.dateofx;
      var formData = app.toFormData(app.formProfile);

      if(pfnamex == ""){
        app.validateformProfile = "Please Insert Name ID";
        setTimeout(function () { app.validateformProfile = "" }.bind(this), 5000);//set timeout notif
        this.$refs.namex.focus();
      }
      else if(pfemail == ""){
        app.validateformProfile = "Please Insert Email";
        setTimeout(function () { app.validateformProfile = "" }.bind(this), 5000);//set timeout notif
        this.$refs.emailx.focus();
      }
      else if(pfdateof == ""){
        app.validateformProfile = "Please Insert DateOfBirth";
        setTimeout(function () { app.validateformProfile = "" }.bind(this), 5000);//set timeout notif
        this.$refs.dateofx.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/profile/viewProfile/update', formData)
        .then(function (response) {
          console.log(response);
          app.formProfile = {};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllProfile();// reload ulang data class
          } 
          else {
            console.log(response);
          }

        });

      }

    },



    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        if(key == "dateofx"){
          form_data.append(key, moment(obj[key]).format('YYYY-MM-DD'));
        }
        else{
           form_data.append(key, obj[key]);
        }
      }
      return form_data;
    }



  }




});