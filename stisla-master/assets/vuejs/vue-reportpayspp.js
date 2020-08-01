var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app         = new Vue({

  el: "#reportPayspp",
  data: {
    validateformRptPay: "",
    showContentPay: "",
  	errorMessage: "",
  	formReportPay: {studentid:'', classid: '',  statustype:'D', paymentid:'', periodyear: year},
    query:'',
    priod: '',
    search_data:[],
    querycl:'',
    search_datacl:[],
    periods: []
  },
  
   components: {
  	vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
    this.getAllPeriod();
  },
  

  methods: {
    
    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },

     //show period
    getAllPeriod: function () {
      axios.get(base_url+'/ci-spp/reportpayspp/viewReportpayspp/viewperiod')
      .then(function (response) {
        //console.log(response);
          app.periods = response.data;
          //console.log(response.data);
        
      });
    },

    //autocomplete
    getDataStudent:function(){
      this.search_data = [];
      axios.post(base_url+'/ci-spp/reportpayspp/viewReportpayspp/searchstudent', {
        query:this.formReportPay.studentid,  priod: this.formReportPay.periodyear 
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getNameStudent:function(name){
      this.formReportPay.studentid = name;
      this.search_data             = [];
    },
    
    
    //autocomplete class
    getDataClass: function(){
      this.search_datacl = [];
      axios.post(base_url+'/ci-spp/reportpayspp/viewReportpayspp/searchclass', {
        querycl:this.formReportPay.classid
      }).then(response => {
        this.search_datacl = response.data;
      });
    },
    
    getNameClass:function(name){
      this.formReportPay.classid  = name;
      this.search_datacl          = [];
    },

    searchPayspp: function () {
       var formData = app.toFormData(app.formReportPay);
        axios.post(base_url+'/ci-spp/reportpayspp/viewReportpayspp/search', formData)
        .then(function (response) {
          console.log(response);
          //app.formReportPay = {};

          if (response.data.status == "ok") {
            app.showContentPay = response.data.content;
          }
          else if (response.data.status == "failed") {
            app.errorMessage   = response.data.msg;
            setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            app.showContentPay = "";
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

    },
    
    
    resetFormRptPay: function(){
      app.formReportPay  = {studentid:'', classid: '',  statustype:'D', paymentid:'', periodyear: year};
      app.showContentPay = "";
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