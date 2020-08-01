var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app         = new Vue({

  el: "#reportSaving",
  data: {
    validateformRptSaving: "",
  	errorMessage: "",
    showContentSaving: "",
  	formReportSaving: {withdrawalid: '', depositid: '', studentid:'', studentname: '', classid: '', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'All'},
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

    //autocomplete
    getDataStudent:function(){
      this.search_data = [];
      axios.post(base_url+'/ci-savings/reportsaving/viewReportSaving/searchstudent', {
        query:this.formReportSaving.studentid
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getNameStudent:function(name, idx){
      this.formReportSaving.studentid      = name;
      this.formReportSaving.studentname    = idx;
      this.search_data = [];
    },
    
    
    //autocomplete class
    getDataClass: function(){
      this.search_datacl = [];
      axios.post(base_url+'/ci-savings/reportsaving/viewReportSaving/searchclass', {
        querycl:this.formReportSaving.classid
      }).then(response => {
        this.search_datacl = response.data;
      });
    },
    
    getNameClass:function(name){
      this.formReportSaving.classid  = name;
      this.search_datacl             = [];
    },

    searchSaving: function () {
       var formData = app.toFormData(app.formReportSaving);
        axios.post(base_url+'/ci-savings/reportsaving/viewReportSaving/search', formData)
        .then(function (response) {
          console.log(response);
          //app.formReportSaving = {};

          if (response.data.status == "ok") {
            app.showContentSaving   = response.data.content;
          }
          else if (response.data.status == "failed") {
             app.errorMessage       = response.data.msg;
             app.showContentSaving  = ""; 
             setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout 
          }
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

    },
  
  
    resetFormRptSaving: function(){
      app.formReportSaving   = {withdrawalid: '', depositid: '', studentid:'', studentname: '', classid: '', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'All'};
      app.showContentSaving  = ""; 
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