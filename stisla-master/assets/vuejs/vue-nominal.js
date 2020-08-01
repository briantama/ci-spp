var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app = new Vue({

  el: "#masterNominal",
  data: {
    validateformNominal: "",
    statusNominal: "",
    nominalread: "",
  	errorMessage: "",
  	successMessage: "",
  	users: [],
    periods:[],
    searchRecord: '10',
    searchQuery:'',
  	formNominal: {classid: "", amount: "", desc: "", periodyear: year},
  	clickedNominal: {},
    query:'',
    search_data:[]
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllNominal();
    this.getAllPeriod();
  },

  methods: {

    //autocomplete
    getData:function(){
      this.search_data = [];
      axios.post(base_url+'/ci-spp/nominal/viewNominalPayment/searchclass', {
        query:this.formNominal.classid
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getName:function(name){
      this.formNominal.classid  = name;
      this.search_data          = [];
      this.$refs.desc.focus();
    },



  	getAllNominal: function () {
  		axios.get(base_url+'/ci-spp/nominal/viewNominalPayment/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.users = response.data;
          console.log(response.data);
  			
  		})
  	},


    //show period
    getAllPeriod: function () {
      axios.get(base_url+'/ci-spp/nominal/viewNominalPayment/viewperiod')
      .then(function (response) {
        //console.log(response);
          app.periods = response.data;
          //console.log(response.data);
        
      });
    },

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/nominal/viewNominalPayment/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.users = response.data;
          console.log(response.data);
        
      })
    },

    showPopupNominal: function(){
      $("#getmodalNominal").modal('show');//show modal form class
      app.formNominal   = {classid: "", amount: "", desc: "", periodyear: year};//reset form;
      app.nominalread   = "";
      app.statusNominal = "";//reset status record;
    },


    addNominal: function () {
      var clsid    = app.formNominal.classid;
      var periodx  = app.formNominal.periodyear;
      var clsnm    = app.formNominal.amount;
      var formData = app.toFormData(app.formNominal);

      if(clsid == ""){
        app.validateformNominal = "Please Insert Class ID";
        setTimeout(function () { app.validateformNominal = "" }.bind(this), 5000);//set timeout notif
        this.$refs.classid.focus();
      }
       if(periodx == ""){
        app.validateformNominal = "Please Insert School Year";
        setTimeout(function () { app.validateformNominal = "" }.bind(this), 5000);//set timeout notif
        this.$refs.periodyear.focus();
      }
      else if(clsnm == ""){
        app.validateformNominal = "Please Insert Nominal Amount";
        setTimeout(function () { app.validateformNominal = "" }.bind(this), 5000);//set timeout notif
        this.$refs.amount.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/nominal/viewNominalPayment/save', formData)
        .then(function (response) {
          console.log(response);
          app.formNominal = {classid: "", amount: "", desc: ""};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllNominal();// reload ulang data class
            $("#getmodalNominal").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectNominal(param) {
      app.clickedNominal = param;
    },


    selectEditNominal(param) {
      app.clickedNominal = param;
      app.nominalread            = "readonly";
      app.formNominal.classid    = param.classid;
      app.formNominal.periodyear = param.schoolyear;
      app.formNominal.amount     = param.nominalamount;
      app.formNominal.desc       = param.description;
      
      if(param.isactive == "N"){
        app.statusNominal          = "Record Is Deleted";
      }
      else{
        app.statusNominal          = "";
      } 
    },


    deleteNominal: function () {
      var formData = app.toFormData(app.clickedNominal);
      axios.post(base_url+'/ci-spp/nominal/viewNominalPayment/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedNominal = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllNominal();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfNominal").modal('hide');//hide modal form class
          
        } else {
          console.log(response);
          //app.errorMessage = response.data.message;
          //setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout notif
        }
      })
    },


    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        form_data.append(key, obj[key]);
      }
      return form_data;
    }

  },

  computed: {
    filteredResources (){
      
      if(this.searchQuery){
        //var idxxx = $('#searchQuery').val();
        //alert(idxxx);
        return this.users.filter((row)=>{
          return this.searchQuery.toLowerCase().split(' ').every(v => row.classid.toLowerCase().includes(v));
        });
      }
      else{
        return this.users;
      }
    
      
    }
  }




});