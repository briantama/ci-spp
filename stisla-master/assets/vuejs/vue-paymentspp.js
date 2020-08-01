var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app         = new Vue({

  el: "#Paymentspp",
  data: {
    //test: 'oke',
    // showinfoStudent: "",
    // showstudent: "",
    // showclass: "", 
    // showstudentname: "", 
    // showgender: "", 
    // showdateofbirth: "", 
    // showschoolyear: "", 
    // shownominal: "",

    // showinfoCardSPP: "",

    validateformSPP: "",
  	errorMessage: "",
    showContentSPP: "",
  	formSPP: {periodyear: year,  studentid:''},
    query:'',
    priod: '',
    search_data:[],
    periods:[]
  },
  
  components: {
  	vuejsDatepicker
  },

  // render (ce){
  //   ce('div', {domProps:{innerHTML:this.showContentSPP}} );
  // },

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
      axios.get(base_url+'/ci-spp/paymentspp/viewPaymentspp/viewperiod')
      .then(function (response) {
        //console.log(response);
          app.periods = response.data;
          //console.log(response.data);
        
      });
    },

    //autocomplete student
    getDataStudent:function(){

      this.search_data = [];
      axios.post(base_url+'/ci-spp/paymentspp/viewPaymentspp/searchstudent', {
        query: this.formSPP.studentid, priod: this.formSPP.periodyear 
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getNameStudent:function(name){
      this.formSPP.studentid   = name;
      this.search_data = [];
    },
    
    

    searchSPP: function () {
      var studentx = app.formSPP.studentid;
      var formData = app.toFormData(app.formSPP);

      if(studentx == ""){
          app.validateformSPP    = "Please Insert StudentID";
          app.showContentSPP     = ""; 
          setTimeout(function () { app.validateformSPP = "" }.bind(this), 5000);//set timeout 
          this.$refs.studentid.focus();
          //this.$refs.amount.focus();
      }
      else
      {

        axios.post(base_url+'/ci-spp/paymentspp/viewPaymentspp/search', formData)
        .then(function (response) {
          console.log(response);
          //app.formSPP = {};

          if (response.data.status == "ok") {
            console.log(response.data.status);
            app.showContentSPP = response.data.content;
            //document.getElementById("showctcspp").innerHTML = response.data.content;
          }
          else if (response.data.status == "failed") {
             app.errorMessage       = response.data.msg;
             app.showContentSPP = ""; 
             setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout 
          }
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },
  
  
    resetFormSPP: function(){
      app.formSPP  = {periodyear: year, studentid:''};
      app.showContentSPP = ""; 
    },    


    checkPrint: function(){
      alert("oke");
    },
    
    
    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        // if(key == "startdate" || key == "enddate"){
        //   form_data.append(key, moment(obj[key]).format('YYYY-MM-DD'));
        // }
        // else{
           form_data.append(key, obj[key]);
        // }
      }
      return form_data;
    },

  

    //percobaan 
    // searchSPPx: function () {
    //   var studentx = app.formSPP.studentid;
    //   var formData = app.toFormData(app.formSPP);

    //   if(studentx == ""){
    //       app.validateformSPP    = "Please Insert StudentID";
    //       app.showinfoStudent     = ""; 
    //       setTimeout(function () { app.validateformSPP = "" }.bind(this), 5000);//set timeout 
    //       this.$refs.studentid.focus();
    //       //this.$refs.amount.focus();
    //   }
    //   else
    //   {

    //     axios.post(base_url+'/ci-spp/paymentspp/viewPaymentspp/searchx', formData)
    //     .then(function (response) {
    //       console.log(response);
    //       //app.formSPP = {};

    //       if (response.data.status == "ok") {
    //         app.showinfoStudent = response.data.content;
    //         //document.getElementById("showctcspp").innerHTML = response.data.content;
    //         //loop variable
    //         var obj = response.data.content;
    //         if(obj){
    //           for (var key in obj) {
    //               var keystudent   = obj[key].studentid;
    //               var keyclass     = obj[key].classid;
    //               var keystudennm  = obj[key].studentname;
    //               var keygender    = obj[key].gender;
    //               var keydateof    = obj[key].dateofbirth;
    //               var keyschool    = obj[key].schoolyear;
    //               var keynominal   = obj[key].nominalamount;
    //           }

    //           app.showstudent     = keystudent; 
    //           app.showclass       = keyclass; 
    //           app.showstudentname = keystudennm; 
    //           app.showgender      = keygender; 
    //           app.showdateofbirth = keydateof; 
    //           app.showschoolyear  = keyschool; 
    //           app.shownominal     = keynominal; 

    //           //call card spp student
    //           app.getStudentCard(keystudent, keyschool);

    //         }
    //         else{
    //           app.showstudent     = ""; 
    //           app.showclass       = ""; 
    //           app.showstudentname = ""; 
    //           app.showgender      = ""; 
    //           app.showdateofbirth = ""; 
    //           app.showschoolyear  = ""; 
    //           app.shownominal     = ""; 
    //         }



    //       }
    //       else if (response.data.status == "failed") {
    //          app.errorMessage       = response.data.msg;
    //          app.showContentSPP = ""; 
    //          setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout 
    //       }
    //       else {
    //         // app.errorMessage = response.data.msg;
    //         // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
    //         console.log(response);
    //       }

    //     });

    //   }

    // },


    // resetFormSPPx: function(){
    //   app.formSPP  = {periodyear: year, studentid:''};
    //   //app.showContentSPP = ""; 
    //   app.showinfoStudent = "";
    // },   


    // getStudentCard: function (std, yr) {
    //   axios.get(base_url+'/ci-spp/paymentspp/viewPaymentspp/searchcard/'+std+'/'+yr)
    //   .then(function (response) {
    //     //console.log(response);
    //       app.showinfoCardSPP = response.data;
    //       console.log(response.data);
        
    //   });
    // },


  },

  computed: {
    contentdisplay: function() {
     return this.showContentSPP;
    }
  },


});