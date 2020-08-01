var base_url    = window.location.origin;
var app         = new Vue({
  el: "#vueSetupPrint",
  data: {
    validateformStp: "",
    errorMessage: "",
  	successMessage: "",
    print: [],
    formPrint: {setupid: '0', setuphead: '', setupfoot: '', setupimg: 'N'},
    uploadedImageLogo:'<img alt="image" src="'+base_url+'/ci-spp/upload/print/default.jpeg" width="240" height="240" class="rounded-circle profile-widget-picture">',
  },


  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getSetupPrint();
  },

  methods: {


  	getSetupPrint: function () {
  		axios.get(base_url+'/ci-spp/setupprint/viewSetupPrint/view')
  		.then(function (response) {
  			//console.log(response);
  				app.print = response.data;
          console.log(response.data);

          var obj = response.data;
          if(obj){
            for (var key in obj) {
              //if(obj[key].AdminImage == "AdminImage"){
                var imageurl = obj[key].setupimage;

                var idxsetup = obj[key].setupprintid;
                var idxhead  = obj[key].setupheader;
                var idxfoot  = obj[key].setupfooter;
                var idxshow  = obj[key].setupimageshow;
              //}
            }

              //check file image exist
              var http   = new XMLHttpRequest();
              var cekimg = (imageurl != "" || typeof imageurl !== "undefined") ? imageurl : "default.jpeg";
              http.open('HEAD', base_url+'/ci-spp/upload/print/'+cekimg, false);
              http.send();
             
              console.log(imageurl);

            if(http.status != 404){
              var urlimg = '<img alt="image" src="'+base_url+'/ci-spp/upload/print/'+cekimg+'" width="240" height="240" class="rounded-circle profile-widget-picture">';
              app.uploadedImageLogo    = urlimg;
              app.formPrint.setupid    = idxsetup;
              app.formPrint.setuphead  = idxhead; 
              app.formPrint.setupfoot  = idxfoot;
              app.formPrint.setupimg   = idxshow;  
            }
            else{
              app.uploadedImageLogo = '<img alt="image" src="'+base_url+'/ci-spp/upload/print/default.jpeg" width="240" height="240" class="rounded-circle profile-widget-picture">';
              
              app.formPrint.setupid    = idxsetup;
              app.formPrint.setuphead  = idxhead; 
              app.formPrint.setupfoot  = idxfoot;
              app.formPrint.setupimg   = idxshow;
            }
          }
          else{
            app.uploadedImageLogo     = '<img alt="image" src="'+base_url+'/ci-spp/upload/print/default.jpeg" width="240" height="240" class="rounded-circle profile-widget-picture">';
            app.formPrint.setupid     = "0";
          }

  			
  		})
  	},


    addPrint: function () {
      var stpid    = app.formPrint.setupid;
      var stphead  = app.formPrint.setuphead;
      var stpfoot  = app.formPrint.setupfoot;
      var stpimg   = app.formPrint.setupimg;
      var formData = app.toFormData(app.formPrint);

      if(stpid == ""){
        app.validateformStp = "Please Insert Setup ID";
        setTimeout(function () { app.validateformStp = "" }.bind(this), 5000);//set timeout notif
        this.$refs.setuphead.focus();
      }
      else if(stphead == ""){
        app.validateformStp = "Please Insert Setup Header";
        setTimeout(function () { app.validateformStp = "" }.bind(this), 5000);//set timeout notif
        this.$refs.setuphead.focus();
      }
      else if(stpfoot == ""){
        app.validateformStp = "Please Insert Setup Footer";
        setTimeout(function () { app.validateformStp = "" }.bind(this), 5000);//set timeout notif
        this.$refs.setupfoot.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/setupprint/viewSetupPrint/save', formData, {
        header:{
         'Content-Type' : 'multipart/form-data'
        }
       }).then(function (response) {
          console.log(response);

          if (response.data.status == "ok") {
            app.formPrint = {setupid: '0', setuphead: '', setupfoot: '', setupimg: 'N'};
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getSetupPrint();// reload ulang data print
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
    },


    testPrint: function(url){
       window.open(base_url+"/ci-spp/"+url,'_blank', 'width=300');
    }

    


  }




});