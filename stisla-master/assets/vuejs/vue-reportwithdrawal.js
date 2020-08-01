var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app         = new Vue({

  el: "#reportWdh",
  data: {
    validateformRptWdh: "",
    showContentWdh: "",
  	errorMessage: "",
  	formReportWdh: {withdrawalid: '', studentid:'', classid: '', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'All'},
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
      axios.post(base_url+'/ci-savings/reportwithdrawal/viewReportWithdrawal/searchstudent', {
        query:this.formReportWdh.studentid
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getNameStudent:function(name){
      this.formReportWdh.studentid = name;
      this.search_data             = [];
    },
    
    
    //autocomplete class
    getDataClass: function(){
      this.search_datacl = [];
      axios.post(base_url+'/ci-savings/reportwithdrawal/viewReportWithdrawal/searchclass', {
        querycl:this.formReportWdh.classid
      }).then(response => {
        this.search_datacl = response.data;
      });
    },
    
    getNameClass:function(name){
      this.formReportWdh.classid  = name;
      this.search_datacl          = [];
    },

    searchWithdrawal: function () {
       var formData = app.toFormData(app.formReportWdh);
        axios.post(base_url+'/ci-savings/reportwithdrawal/viewReportWithdrawal/search', formData)
        .then(function (response) {
          console.log(response);
          //app.formReportWdh = {};

          if (response.data.status == "ok") {
            app.showContentWdh = response.data.content;
          }
          else if (response.data.status == "failed") {
            app.errorMessage   = response.data.msg;
            setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            app.showContentWdh = "";
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

    },
    
    
    resetFormRptWdh: function(){
      app.formReportWdh  = {withdrawalid: '', studentid:'', classid: '', startdate: year+'-'+months+'-'+date, enddate: year+'-'+months+'-'+date, statustype:'All'};
      app.showContentWdh = "";
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