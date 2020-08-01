var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app         = new Vue({

  el: "#reportCash",
  data: {
    validateformRptCash: "",
  	errorMessage: "",
    showContentCash: "",
  	formReportCash: {refid: '', adminname:'', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'Y', reporttype: 'DC'},
    query:'',
    search_data:[],
    querycl:'',
    search_datacl:[]
  },
  
  components: {
  	vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  },

  methods: {
    
    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },

  
    searchCash: function () {
       var formData = app.toFormData(app.formReportCash);
        axios.post(base_url+'/ci-spp/reportcash/viewReportCash/search', formData)
        .then(function (response) {
          console.log(response);
          //app.formReportCash = {};

          if (response.data.status == "ok") {
            app.showContentCash   = response.data.content;
          }
          else if (response.data.status == "failed") {
             app.errorMessage       = response.data.msg;
             app.showContentCash  = ""; 
             setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout 
          }
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

    },
  
  
    resetFormRptCash: function(){
      app.formReportCash   = {refid: '', adminname:'', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'Y', reporttype: 'DC'};
      app.showContentCash  = ""; 
    },    
    
    
    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        if(key == "startdate" || key == "enddate"){
          form_data.append(key, moment(obj[key]).format('YYYY-MM-DD'));
        }
        else{
           form_data.append(key, obj[key]);
        }
      }
      return form_data;
    }

  },


});