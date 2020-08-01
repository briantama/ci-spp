var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;
var app         = new Vue({

  el: "#transWithdrawal",
  data: {
    validateformWithdrawal: "",
    statusWithdrawal: "",
  	errorMessage: "",
  	successMessage: "",
  	withdrawal: [],
    searchRecord: '10',
    numbering: '',
    searchQuery:'',
  	formWithdrawal: {withdrawalid: '', studentid:'', balance: 0, total: 0, withdrawaldate:''},
  	clickedWithdrawal: {},
    query:'',
    search_data:[]
  },
  
  components: {
  	vuejsDatepicker
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllWithdrawal();
  },

  methods: {
    
    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },

    //autocomplete
    getData:function(){
      this.search_data = [];
      axios.post(base_url+'/ci-savings/withdrawal/viewWithdrawal/searchstudent', {
        query:this.formWithdrawal.studentid
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getName:function(name, totalx){
      this.formWithdrawal.studentid      = name;
      this.formWithdrawal.balance        = totalx;
      this.formWithdrawal.total          = totalx;
      this.search_data = [];
    },


    //calculate withdrawal
    calcWithdrawal: function() {
      if(parseInt(this.$refs.entered.value) > parseInt(this.$refs.balance.value)){
        app.formWithdrawal.entered   = "";
        app.validateformWithdrawal = "Withdrawal Entered More Than Withdrawal Balance";
        setTimeout(function () { app.validateformWithdrawal = "" }.bind(this), 5000);//set timeout notif
        this.$refs.entered.focus();
      }
      else if(parseInt(this.$refs.entered.value) <= 0){
        app.validateformWithdrawal   = "Withdrawal totals cannot be less than zero";
        app.formWithdrawal.entered   = "";
        setTimeout(function () { app.validateformWithdrawal = "" }.bind(this), 5000);//set timeout notif
        this.$refs.entered.focus();
      }
      else{
        var totalwd             = parseInt(this.$refs.balance.value) - parseInt(this.$refs.entered.value);
        app.$refs.total.value   = totalwd;
      }

    },


  	getAllWithdrawal: function () {
  		axios.get(base_url+'/ci-savings/withdrawal/viewWithdrawal/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.withdrawal = response.data;
          console.log(response.data);
  			
  		})
  	},


    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-savings/withdrawal/viewWithdrawal/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.withdrawal = response.data;
          console.log(response.data);
        
      })
    },


    //numbering withdrawal
    getNumberingWithdrawal: function () {
      axios.get(base_url+'/ci-savings/withdrawal/viewWithdrawal/getnumber')
      .then(function (response) {
        //console.log(response);
          app.numbering                   = response.data.GetID;
          app.formWithdrawal.withdrawalid = response.data.GetID;
          //$('#withdrawalid').val(response.data.GetID);
          //this.$refs.withdrawalid.innerText = response.data.GetID;
          console.log(response.data);
        
      })
    },

    showPopupWithdrawal(){
      $("#getmodalWithdrawal").modal('show');//show modal form class
      app.formWithdrawal                = {withdrawalid: ''};//reset form;
      app.getNumberingWithdrawal();//numbering withdrawal
      app.statusWithdrawal              = "";//reset record;
      app.formWithdrawal.withdrawaldate = year+"-"+months+"-"+date;//reset record;
      app.formWithdrawal.studentid      = "";//reset record;
      app.formWithdrawal.balance        = "0";//reset record;
      app.formWithdrawal.entered        = "";//reset record;
      app.formWithdrawal.total          = "0";//reset record;


    },


    addWithdrawal: function () {
       var wdhdate  = app.formWithdrawal.withdrawaldate;
       var studentx = app.formWithdrawal.studentid;
       var enteredx = app.formWithdrawal.entered;
       var formData = app.toFormData(app.formWithdrawal);

       if(wdhdate == ""){
         app.validateformWithdrawal = "Please Insert Withdrawal Date";
         setTimeout(function () { app.validateformWithdrawal = "" }.bind(this), 5000);//set timeout notif
         this.$refs.withdrawaldate.focus();
       }
       else if(studentx == ""){
         app.validateformWithdrawal = "Please Insert StudentID";
         setTimeout(function () { app.validateformWithdrawal = "" }.bind(this), 5000);//set timeout notif
         this.$refs.studentid.focus();
       }
       else if(enteredx.trim() == "" || enteredx <= 0){
         app.validateformWithdrawal = "Please Insert Withdrawal Entered";
         setTimeout(function () { app.validateformWithdrawal = "" }.bind(this), 5000);//set timeout notif
         this.$refs.entered.focus();
       }
       else{
      
        axios.post(base_url+'/ci-savings/withdrawal/viewWithdrawal/save', formData)
        .then(function (response) {
          console.log(response);
          app.formWithdrawal = {};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = ""; }.bind(this), 5000);//set timeout notif
            app.getAllWithdrawal();// reload ulang data class
            $("#getmodalWithdrawal").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectWithdrawal(param) {
      app.clickedWithdrawal = param;
    },


    selectEditWithdrawal(param) {
      app.clickedWithdrawal = param;
      app.formWithdrawal.withdrawalid    = param.WithdrawalID;
      app.formWithdrawal.withdrawaldate  = param.WithdrawalDate;
      app.formWithdrawal.studentid       = param.StudentID;//reset record;
      app.formWithdrawal.balance         = "0";//reset record;
      app.formWithdrawal.entered         = param.TotalWithdrawal;//reset record;
      app.formWithdrawal.total           = "0";//reset record;


      if(param.IsActive == "N"){
        app.statusWithdrawal          = "Record Is Deleted";
      }
      else{
        app.statusWithdrawal          = "";
      } 
    },


    deleteWithdrawal: function () {
      var formData = app.toFormData(app.clickedWithdrawal);
      axios.post(base_url+'/ci-savings/withdrawal/viewWithdrawal/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedWithdrawal = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllWithdrawal();
          setTimeout(function () { app.successMessage = ""; }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfWithdrawal").modal('hide');//hide modal form class
          
        } else {
          console.log(response);
          //app.errorMessage = response.data.message;
          //setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);//set timeout notif
        }
      });
    },


    toFormData: function (obj) {
      var form_data = new FormData();
      for (var key in obj) {
        if(key == "withdrawaldate"){
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
      //if(this.searchQuery){
      // return this.withdrawal.filter((row)=>{
      //   return row.withdrawalID.toLowerCase().startsWith(this.searchQuery);
      // })

      if(this.searchQuery){
        //var idxxx = $('#searchQuery').val();
        //alert(idxxx);
        return this.withdrawal.filter((row)=>{
          return this.searchQuery.toLowerCase().split(' ').every(v => row.WithdrawalID.toLowerCase().includes(v));
        });
      }
      else{
        return this.withdrawal;
      }

    }
  }




});