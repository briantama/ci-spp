var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app = new Vue({

  el: "#masterCashout",
  data: {
    validateformCashout: "",
    statusCashout: "",
    cashoutread: "",
  	errorMessage: "",
  	successMessage: "",
  	users: [],
    searchRecord: '10',
    searchQuery:'',
    numbering:'',
  	formCashout: {cashoutid: "", cashdate: year+"-"+months+"-"+date, cashamount: "0", cashinamount: "0",  desc: ""},
  	clickedCashout: {},
  },

  components: {
    vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllCashOut();
  },

  methods: {


    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },


  	getAllCashOut: function () {
  		axios.get(base_url+'/ci-spp/cashout/viewCashOut/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.users = response.data;
          console.log(response.data);
  			
  		})
  	},

    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-spp/cashout/viewCashOut/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.users = response.data;
          console.log(response.data);
        
      })
    },


     //numbering deposit
    getNumberingCashOut: function () {
      axios.get(base_url+'/ci-spp/cashout/viewCashOut/getnumber')
      .then(function (response) {
        //console.log(response);
          app.numbering               = response.data.getid;
          app.formCashout.cashoutid   = response.data.getid;
          //$('#depositid').val(response.data.GetID);
          console.log(response.data);
        
      })
    },


    getTotalCashin: function () {
      axios.get(base_url+'/ci-spp/cashout/viewCashOut/total')
      .then(function (response) {
        //console.log(response);
          app.numbering                 = response.data.totalin;
          app.formCashout.cashtotal     = response.data.totalin;
          //$('#depositid').val(response.data.GetID);
          console.log(response.data.totalin);
        
      })
    },

     //calculate withdrawal
    calcCashout: function() {
      if(parseInt(this.$refs.cashamount.value) > parseInt(this.$refs.cashtotal.value)){
        app.formCashout.cashamount   = "0";
        app.validateformCashout = "Amounnt Entered More Than Cash In Balance";
        setTimeout(function () { app.validateformCashout = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashtotal.focus();
      }
      else if(parseInt(this.$refs.cashamount.value) <= 0){
        app.validateformCashout   = "Amounnt totals cannot be less than zero";
        app.formCashout.cashamount   = "0";
        setTimeout(function () { app.validateformCashout = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashtotal.focus();
      }
      else{
        var totalwd             = parseInt(this.$refs.cashtotal.value) - parseInt(this.$refs.cashamount.value);
        app.formCashout.total   = totalwd;
      }

    },


    showPopupCashOut: function(){
      $("#getmodalCashOut").modal('show');//show modal form class
      app.formCashout   = {cashoutid: "", cashdate: year+"-"+months+"-"+date, cashamount: "0", cashtotal: "0", total:"0", desc: ""},
      app.getNumberingCashOut();
      app.getTotalCashin();
      app.cashoutread   = "";
      app.statusCashout = "";//reset status record;
    },


    addCashOut: function () {
      var cashid = app.formCashout.cashoutid;
      var cashdt = app.formCashout.cashdate;
      var casham = app.formCashout.cashamount;
      var formData = app.toFormData(app.formCashout);

      if(cashid == ""){
        app.validateformCashout = "Please Insert CashOut ID";
        setTimeout(function () { app.validateformCashout = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashoutid.focus();
      }
      else if(cashdt == ""){
        app.validateformCashout = "Please Insert Cash Date";
        setTimeout(function () { app.validateformCashout = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashdate.focus();
      }
       else if(casham == "" || casham <= "0"){
        app.validateformCashout = "Please Insert Cash Amount";
        setTimeout(function () { app.validateformCashout = "" }.bind(this), 5000);//set timeout notif
        this.$refs.cashamount.focus();
      }
      else{
      
        axios.post(base_url+'/ci-spp/cashout/viewCashOut/save', formData)
        .then(function (response) {
          console.log(response);
          app.formCashout = {cashoutid: "", cashdate: "", cashamount: "0", desc: ""}

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllCashOut();// reload ulang data class
            $("#getmodalCashOut").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectCashOut(param) {
      app.clickedCashout = param;
    },


    selectEditCashOut(param) {
      app.clickedCashout         =  param;
      app.cashoutread            = "readonly";
      app.formCashout.cashoutid  = param.cashoutid;
      app.formCashout.cashdate   = param.cashdate;
      app.formCashout.cashamount = param.cashamountout;
      app.formCashout.desc       = param.description;
      
      if(param.isactive == "N"){
        app.statusCashout          = "Record Is Deleted";
      }
      else{
        app.statusCashout          = "";
      } 
    },


    deleteCashOut: function () {
      var formData = app.toFormData(app.clickedCashout);
      axios.post(base_url+'/ci-spp/cashout/viewCashOut/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedCashout = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllCashOut();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfCashOut").modal('hide');//hide modal form class
          
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
          return this.searchQuery.toLowerCase().split(' ').every(v => row.cashoutid.toLowerCase().includes(v));
        });
      }
      else{
        return this.users;
      }
    
      
    }
  }




});