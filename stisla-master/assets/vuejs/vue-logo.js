var base_url    = window.location.origin;
var app         = new Vue({
  el: "#vueLogo",
  data: {
    errorMessage: "",
  	successMessage: "",
    logo: [],
    formLogo: {setupid: '', setupname: '', setuptitle: '', setupdesc: ''},
    uploadedImageLogo:'<img alt="image" src="'+base_url+'/ci-spp/upload/logo/default.jpeg" width="240" height="240" class="rounded-circle profile-widget-picture">',
  },


  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllSetup();
  },

  methods: {


  	getAllSetup: function () {
  		axios.get(base_url+'/ci-spp/logo/viewLogo/view')
  		.then(function (response) {
  			//console.log(response);
  				app.logo = response.data;
          console.log(response.data);

          var obj = response.data;
          for (var key in obj) {
            //if(obj[key].AdminImage == "AdminImage"){
              var imageurl = obj[key].setupimageLlogo;

              var idxsetup = obj[key].setupprofileid;
              var idxtitle = obj[key].setuptitle;
              var idxname  = obj[key].setupname;
              var idxdesc  = obj[key].setupdescription;
            //}
          }

            //check file image exist
            var http   = new XMLHttpRequest();
            var cekimg = (imageurl != "" || typeof imageurl !== "undefined") ? imageurl : "default.jpeg";
            http.open('HEAD', base_url+'/ci-spp/upload/logo/'+cekimg, false);
            http.send();
           
            console.log(imageurl);

          if(http.status != 404){
            var urlimg = '<img alt="image" src="'+base_url+'/ci-spp/upload/logo/'+cekimg+'" width="240" height="240" class="rounded-circle profile-widget-picture">';
            app.uploadedImageLogo       = urlimg;
            app.formLogo.setupid    = idxsetup;
            app.formLogo.setuptitle = idxtitle; 
            app.formLogo.setupname  = idxname;
            app.formLogo.setupdesc  = idxdesc;  
          }
          else{
            app.uploadedImageLogo = '<img alt="image" src="'+base_url+'/ci-spp/upload/logo/default.jpeg" width="240" height="240" class="rounded-circle profile-widget-picture">';
            app.uploadedImageLogo       = urlimg;
            app.formLogo.setupid    = idxsetup;
            app.formLogo.setuptitle = idxtitle; 
            app.formLogo.setupname  = idxname;
            app.formLogo.setupdesc  = idxdesc;
          }

  			
  		})
  	},


    uploadImage:function(){

       var formData = app.toFormData(app.formLogo);


       axios.post(base_url+'/ci-spp/logo/viewLogo/save', formData, {
        header:{
         'Content-Type' : 'multipart/form-data'
        }
       }).then(function(response){
        if(response.data.status == 'ok'){
      
         app.successMessage     = response.data.msg;
         setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
         var urlimg             = '<img alt="image" src="'+base_url+'/ci-spp/upload/logo/'+response.data.filenm+'" width="240" height="240" class="rounded-circle profile-widget-picture">';
         app.uploadedImageLogo      = urlimg;
         //app.$refs.file.value   = '';

        }
        else   
        {

         app.errorMessage       = response.data.msg;
         setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
         //app.uploadedImageLogo = '';

        }
        



       });
    },



    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        if(key == "file"){
          app.file = app.$refs.file.files[0];
          form_data.append(key, app.file);
        }
        else{
          form_data.append(key, obj[key]);
        }

      }
      return form_data;
    }

    


  }




});