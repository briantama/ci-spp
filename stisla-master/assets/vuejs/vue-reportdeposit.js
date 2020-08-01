var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app         = new Vue({

  el: "#reportDeposit",
  data: {
    validateformRptDeposit: "",
  	errorMessage: "",
    showContentDeposit: "",
  	formReportDeposit: {depositid: '', studentid:'', classid: '', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'All'},
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
      axios.post(base_url+'/ci-savings/reportdeposit/viewReportDeposit/searchstudent', {
        query:this.formReportDeposit.studentid
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getNameStudent:function(name){
      this.formReportDeposit.studentid      = name;
      this.search_data = [];
    },
    
    
    //autocomplete class
    getDataClass: function(){
      this.search_datacl = [];
      axios.post(base_url+'/ci-savings/reportdeposit/viewReportDeposit/searchclass', {
        querycl:this.formReportDeposit.classid
      }).then(response => {
        this.search_datacl = response.data;
      });
    },
    
    getNameClass:function(name){
      this.formReportDeposit.classid  = name;
      this.search_datacl              = [];
    },

    searchDeposit: function () {
       var formData = app.toFormData(app.formReportDeposit);
        axios.post(base_url+'/ci-savings/reportdeposit/viewReportDeposit/search', formData)
        .then(function (response) {
          console.log(response);
          //app.formReportDeposit = {};

          if (response.data.status == "ok") {
            app.showContentDeposit = response.data.content;
          }
          else if (response.data.status == "failed") {
             app.errorMessage       = response.data.msg;
             app.showContentDeposit = ""; 
             setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout 
          }
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

    },
  
  
    resetFormRptDeposit: function(){
      app.formReportDeposit  = {depositid: '', studentid:'', classid: '', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'All'};
      app.showContentDeposit = ""; 
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