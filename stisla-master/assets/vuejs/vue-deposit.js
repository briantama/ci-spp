var base_url    = window.location.origin;
var today       = new Date();
var date        = today.getDate();
var month       = today.getMonth() + 1;
var year        = today.getFullYear();
var months      = (month.length > 1) ? month :  '0'+month;

// //autocomplete vue js
// Vue.component('auto-complete', {
//     template:`
//    <div>
//       <input type="text" ref="studentid" id="studentid" name="studentid" placeholder="Enter Country name..." v-model="formDeposit.studentid" @keyup="getData()" autocomplete="off" class="form-control input-lg" />
//       <div class="panel-footer" v-if="search_data.length">
//         <ul class="list-group">
//           <a href="#" class="list-group-item" v-for="data1 in search_data" @click="getName(data1.keystudent, data1.saldo)">{{ data1.student }}</a>
//         </ul>
//       </div>
//     </div>
//     `,
//     data:function(){
//       return{
//         query:'',
//         formDeposit: {studentid:''},
//         search_data:[]
//       }
//     },
//     methods:{
//       getData:function(){
//         this.search_data = [];
//         axios.post(base_url+'/ci-savings/deposit/viewDeposit/searchstudent', {
//           query:this.formDeposit.studentid
//         }).then(response => {
//           this.search_data = response.data;
//         });
//       },
//       getName:function(name, totalx){
//         this.formDeposit.studentid = name;
//         this.formDeposit.balance   = totalx;
//         this.search_data = [];
//       }
//     }
//   });




var app = new Vue({

  el: "#transDeposit",
  data: {
    validateformDeposit: "",
    statusDeposit: "",
  	errorMessage: "",
  	successMessage: "",
  	deposit: [],
    searchRecord: "10",
    contenttable: "",
    numbering: '',
    searchQuery:'',
  	formDeposit: {depositid:'', studentid:'', depositdate: ''},
  	clickedDeposit: {},
    query:'',
    search_data:[]
  },

  mounted: function () {
  	console.log("Vue.js is running bro...");
  	this.getAllDeposit();
    //this.getNumberingDeposit();
  },
  
   components: {
  	vuejsDatepicker
  },

  methods: {
    
    //format date
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },

    //autocomplete
    getData:function(){
      this.search_data = [];
      axios.post(base_url+'/ci-savings/deposit/viewDeposit/searchstudent', {
        query:this.formDeposit.studentid
      }).then(response => {
        this.search_data = response.data;
      });
    },
    
    getName:function(name, totalx){
      this.formDeposit.studentid      = name;
      this.formDeposit.balance        = totalx;
      this.formDeposit.totaldeposit   = totalx;
      this.search_data = [];
    },

    //calculate deposit
    calcDeposit: function() {
     if(parseInt(this.$refs.entered.value) <= 0){
        app.validateformDeposit   = "Withdrawal totals cannot be less than zero";
        app.formDeposit.entered   = "";
        setTimeout(function () { app.validateformDeposit = "" }.bind(this), 5000);//set timeout notif
        this.$refs.entered.focus();
      }
      else{
        var totaldp   = parseInt(this.$refs.balance.value) + parseInt(this.$refs.entered.value);
        app.$refs.totaldeposit.value   = totaldp;
      }
    },


  	getAllDeposit: function () {
  		axios.get(base_url+'/ci-savings/deposit/viewDeposit/view/10')
  		.then(function (response) {
  			//console.log(response);
  				app.deposit = response.data;
          console.log(response.data);
  			
  		})
  	},


    selectRecord: function(){
      var idxrecord = app.searchRecord;
      axios.get(base_url+'/ci-savings/deposit/viewDeposit/view/'+idxrecord)
      .then(function (response) {
        //console.log(response);
          app.deposit = response.data;
          console.log(response.data);
        
      })
    },

    //numbering deposit
    getNumberingDeposit: function () {
      axios.get(base_url+'/ci-savings/deposit/viewDeposit/getnumber')
      .then(function (response) {
        //console.log(response);
          app.numbering             = response.data.GetID;
          app.formDeposit.depositid = response.data.GetID;
          //$('#depositid').val(response.data.GetID);
          console.log(response.data);
        
      })
    },

    showPopupDeposit(){
      $("#getmodalDeposit").modal('show');//show modal form class
      app.formDeposit              = {depositid:''};//reset form;
      app.getNumberingDeposit();//numbering deposit
      app.statusDeposit            = "";//reset record;
      app.formDeposit.depositdate  = year+"-"+months+"-"+date;//reset record;
      app.formDeposit.studentid    = "";//reset record;
      app.formDeposit.balance      = "0";//reset record;
      app.formDeposit.entered      = "";//reset record;
      app.formDeposit.totaldeposit = "0";//reset record;


    },


    addDeposit: function () {
       var studentx = app.formDeposit.studentid;
       var enteredx = app.formDeposit.entered;
       var depodate = app.formDeposit.depositdate;
       var formData = app.toFormData(app.formDeposit);

       if(studentx == ""){
         app.validateformDeposit = "Please Insert Student ID";
         setTimeout(function () { app.validateformDeposit = "" }.bind(this), 5000);//set timeout notif
         this.$refs.studentid.focus();
       }
       else if(enteredx.trim() == "" || enteredx <= 0){
         app.validateformDeposit = "Please Insert Deposit Entered";
         setTimeout(function () { app.validateformDeposit = "" }.bind(this), 5000);//set timeout notif
         this.$refs.entered.focus();
       }
       else if(depodate == ""){
         app.validateformDeposit = "Please Insert Deposit Date";
         setTimeout(function () { app.validateformDeposit = "" }.bind(this), 5000);//set timeout notif
         this.$refs.depositdate.focus();
       }
       else{
      
        axios.post(base_url+'/ci-savings/deposit/viewDeposit/save', formData)
        .then(function (response) {
          console.log(response);
          app.formDeposit = {};

          if (response.data.status == "ok") {
            app.successMessage = response.data.msg;
            setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
            app.getAllDeposit();// reload ulang data class
            $("#getmodalDeposit").modal('hide');//hide modal form class
          } 
          else {
            // app.errorMessage = response.data.msg;
            // setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            console.log(response);
          }

        });

      }

    },


    selectDeposit(param) {
      app.clickedDeposit = param;
    },


    selectEditDeposit(param) {
      app.clickedDeposit = param;
      app.formDeposit.depositid    = param.DepositID;
      app.formDeposit.depositdate  = param.DepositDate;
      app.formDeposit.studentid    = param.StudentID;//reset record;
      app.formDeposit.balance      = "0";//reset record;
      app.formDeposit.entered      = param.TotalDeposit;//reset record;
      app.formDeposit.totaldeposit = "0";//reset record;


      if(param.IsActive == "N"){
        app.statusDeposit          = "Record Is Deleted";
      }
      else{
        app.statusDeposit          = "";
      } 
    },


    deleteDeposit: function () {
      var formData = app.toFormData(app.clickedDeposit);
      axios.post(base_url+'/ci-savings/deposit/viewDeposit/delete', formData)
      .then(function (response) {
        console.log(response);
        app.clickedDeposit = {};

        if (response.data.status == "ok") {
          
          app.successMessage = response.data.caption;
          app.getAllDeposit();
          setTimeout(function () { app.successMessage = "" }.bind(this), 5000);//set timeout notif
          $("#getmodalcnfDeposit").modal('hide');//hide modal form class
          
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
        if(key == "depositdate"){
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
      // return this.deposit.filter((row)=>{
      //   return row.DepositID.toLowerCase().startsWith(this.searchQuery);
      // })

      if(this.searchQuery){
        //var idxxx = $('#searchQuery').val();
        //alert(idxxx);
        return this.deposit.filter((row)=>{
          return this.searchQuery.toLowerCase().split(' ').every(v => row.DepositID.toLowerCase().includes(v));
        });
      }
      else{
        return this.deposit;
      }

    }
  }




});