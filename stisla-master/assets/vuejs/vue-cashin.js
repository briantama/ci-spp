var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app = new Vue({

  el: "#masterCashin",
  data: {
    validateformCashin: "",
    statusCashin: "",
    cashinread: "",
  	errorMessage: "",
  	successMessage: "",
  	users: [],
    searchRecord: '10',
    searchQuery:'',
  	formCashin: {cashinid: "", cashdate: year+"-"+months+"-"+date, cashamount: "0", desc: ""},
  	clickedCashin: {},
  },

  components: {
    vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllCashIn();
  },

  methods: {


    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },


  	getAllCashIn: function () {
  		axios.get(base_url+'/ci-spp/cashin/viewCashIn/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.users = response.data;
          console.log(response.data);
  			
  		})
  	},

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/cashin/viewCashIn/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.users = response.data;
          console.log(response.data);
        
      })
    },


     //numbering deposit
    getNumberingCashIn: function () {
      axios.get(base_url+'/ci-spp/cashin/viewCashIn/getnumber')
      .then(function (response) {
        //console.log(response);
          app.numbering             = response.data.getid;
          app.formCashin.cashinid   = response.data.getid;
          //$('#depositid').val(response.data.GetID);
          console.log(response.data);
        
      })
    },


    showPopupCashIn: function(){
      $("#getmodalCashIn").modal('show');//show modal form class
      app.formCashin   = {cashinid: "", cashdate: year+"-"+months+"-"+date, cashamount: "0", desc: ""},
      app.getNumberingCashIn();
      app.cashinread   = "";
      app.statusCashin = "";//reset status record;
    },


    addCashin: function () {
      var cashid = app.formCashin.cashinid;
      var cashdt = app.formCashin.cashdate;
      var casham = app.formCashin.cashamount;
      var formData = app.toFormData(app.formCashin);

      if(cashid == ""){
        app.validateformCashin = "Please Insert addCashIn ID";
        setTimeout(function () { app.validateformCashin = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashinid.focus();
      }
      else if(cashdt == ""){
        app.validateformCashin = "Please Insert Cash Date";
        setTimeout(function () { app.validateformCashin = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashdate.focus();
      }
       else if(casham == "" || casham <= "0"){
        app.validateformCashin = "Please Insert Cash Amount";
        setTimeout(function () { app.validateformCashin = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashamount.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/cashin/viewCashIn/save', formData)
        .then(function (response) {
          console.log(response);
          app.formCashin = {cashinid: "", cashdate: "", cashamount: "0", desc: ""}

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllCashIn();// reload ulang data class
            $("#getmodalCashIn").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectCashIn(param) {
      app.clickedCashin = param;
    },


    selectEditCashIn(param) {
      app.clickedCashin         =  param;
      app.cashinread            = "readonly";
      app.formCashin.cashinid   = param.cashinid;
      app.formCashin.cashdate   = param.cashdate;
      app.formCashin.cashamount = param.cashamount;
      app.formCashin.desc       = param.description;
      
      if(param.isactive == "N"){
        app.statusCashin          = "Record Is Deleted";
      }
      else{
        app.statusCashin          = "";
      } 
    },


    deleteCashIn: function () {
      var formData = app.toFormData(app.clickedCashin);
      axios.post(base_url+'/ci-spp/cashin/viewCashIn/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedCashin = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllCashIn();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfCashIn").modal('hide');//hide modal form class
          
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
        if(key == "cashdate"){
          form_data.append(key, moment(obj[key]).format('YYYY-MM-DD'));
        }
        else{
           form_data.append(key, obj[key]);
        }
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
          return this.searchQuery.toLowerCase().split(' ').every(v => row.cashinid.toLowerCase().includes(v));
        });
      }
      else{
        return this.users;
      }
    
      
    }
  }




});