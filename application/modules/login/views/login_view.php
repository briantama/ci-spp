<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Administrator</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/modules/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/css/components.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/stisla-master/assets/css/animate.css">
</head>

<body>
  <div id="mainView">
    <section class="section animate__animated animate__shakeY">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              
              <?php

                $imgurl = "default.jpeg";
                $stptl  = "Apps Payment SPP Student";
                $res    = $this->db->query('
                                            SELECT  setupimage, setupname
                                            FROM    m_setupprofile
                                        ');
                if ($res->num_rows() > 0) {
                  $keyval = $res->row();
                  $imgurl = $keyval->setupimage;
                  $stptl  = $keyval->setupname;
                }

                if($imgurl != ""){
                  $uri = "./upload/profile/".$imgurl;
                  if(file_exists($uri)){
                    $urlimg = base_url()."/upload/profile/".$imgurl;
                  }
                  else{
                    $urlimg = base_url()."/upload/profile/default.jpeg";
                  }
                }
                else{
                  $urlimg = base_url()."/upload/profile/default.jpeg";
                }

              ?>

              <img src="<?php echo $urlimg; ?>" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4 ><?php echo $stptl; ?></h4></div>

              <!--show messege alert -->
              <!-- notif-->
              <div v-if="errorMessage">
                <div class="alert alert-danger alert-dismissible show animate__animated animate__backInLeft">
                  <div class="alert-body">
                      <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                      </button>
                      <i class="fa fa-times"></i> {{ errorMessage }}
                  </div>
                </div>
              </div>


              <div v-if="successMessage">
                <div class="alert alert-success alert-dismissible show animate__animated animate__rubberBand">
                  <div class="alert-body">
                      <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                      </button>
                      <i class="fa fa-check"></i> {{ successMessage }}
                  </div>
                </div>
              </div>
              <!-- end notif-->



              <div class="card-body">
                <!-- <form method="POST" action="#" class="needs-validation" novalidate=""> -->
                  <div class="form-group">
                    <label for="email">UserName</label>
                    <input id="text" type="username" class="form-control" name="username" id="username" ref="username" v-model="formLogin.username" tabindex="1" required autofocus placeholder="UserName : brian">
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="#" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" ref="password" v-model="formLogin.password" tabindex="2" required placeholder="Password : brian">
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" @click="getLogin();" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                <!-- </form> -->
              
              </div>
            </div>
           
            <div class="simple-footer">
              Copyright &copy; Apps Bryn 2018 - <?php echo date('Y'); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- vue js --->
  <script src="<?php echo base_url(); ?>/stisla-master/assets/vuejs/axios.min.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/vuejs/vue.min.js"></script>

  <!-- General JS Scripts -->
  <script src="<?php echo base_url(); ?>/stisla-master/assets/modules/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/modules/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/modules/tooltip.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/modules/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/modules/jquery.nicescroll.min.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/modules/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/js/stisla.js"></script>


   <!-- Template JS File -->
  <script src="<?php echo base_url(); ?>/stisla-master/assets/js/scripts.js"></script>
  <script src="<?php echo base_url(); ?>/stisla-master/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script type="text/javascript">

  $('#username').focus();//set focus username

  var base_url = window.location.origin;
  var app     = new Vue({

    el: "#mainView",
    data: {
      errorMessage: "",
      successMessage: "",
      formLogin: {username: "", password: ""}
    },

    mounted: function () {
      console.log("Vue.js is running...");
    },

    methods: {
      getLogin: function () {
       var usernm = app.formLogin.username;
       var pswd   = app.formLogin.password;
       var formData = app.toFormData(app.formLogin);

       if(usernm == ""){
          app.errorMessage = "Please Insert UserName";
          setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
          this.$refs.username.focus();
       }
       else if(pswd == ""){
          app.errorMessage = "Please Insert Password";
          setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
          this.$refs.password.focus();
       }
       else
       {
        
          axios.post(base_url+'/ci-spp/login/getlogin', formData)
          .then(function (response) {
            console.log(response);
            app.formLogin = {username: "", password: ""};

            if (response.data.log.valid == "0") 
            {
              //alert("failed");
              app.errorMessage = response.data.log.notif;
              setTimeout(function () { app.errorMessage = "" }.bind(this), 5000);
            } 
            else 
            {
              //alert("success");
              app.successMessage = response.data.log.notif;
              setTimeout(function () { app.successMessage = "" }.bind(this), 5000);
              window.location.assign("<?= base_url(); ?>dasbor"); 
            }
          });

        }
      },


      toFormData: function (obj) {
        var form_data = new FormData();
        for (var key in obj) {
          form_data.append(key, obj[key]);
        }
        return form_data;
      }



    }
  });


  </script>

</body>
</html>
