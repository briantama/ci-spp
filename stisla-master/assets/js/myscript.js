function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function numberFormat(idx){
  return parseInt(idx).toLocaleString(); 
}

function block() {
  var base_url  = window.location.origin;
  $.blockUI({ message : "<img src='"+base_url+"/ci-savings/stisla-master/images/load.gif' width='100px' height='100px' />",  css: { border: 'none', background: 'none' }  });
  //setTimeout(unBlock, 5000); 
}

function unBlock() {
  $.unblockUI();
}


function callpage(id, clsp="", nvitem=''){ 
    //alert(id);
    if(id != ""){
    	var base_url  = window.location.origin;
        var dataString = 'content='+id;
        block();
        $.ajax({
            type : "POST",
            url  : id,
            data : dataString,
            success: function(result){
            	    //$("#load-content").hide();
            	    unBlock();
                    $("#body-ctntl").html(result);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    
                    //active class a
                    $('li.active').removeClass('active');
                    $('#'+clsp).addClass('active');
                    $('#'+nvitem).addClass('active');
                    //

                    // //active class li
                    // if(nvitem != ""){
                    //     $('li').removeClass('active');
                    //     $('#'+nvitem).addClass('active');
                    //  }
                    //

                }});
    }
    else{
        alert("Ooops Terjadi Kesalahan, Silahkan Coba Lagi Nanti.");
    }
}


function blockForm(param){
	var base_url  = window.location.origin;
	$('#'+param).block({
       message: "<img src='"+base_url+"/ci-savings/stisla-master/images/load2.gif' width='80px' height='80px' />",  css: { border: 'none', background: 'none' } 
    });
}

function unblockForm(param) {
 	$('#'+param).unblock();
}



function showPopupformspp(nominal, studentx, monthx, year){
    $("#formcardspp").modal('show');
    $("#monthid").val(monthx);
    $("#studenx").val(studentx);
    $("#schoolyear").val(year);
    $("#costspp").val(nominal);
}

//multi payment
function showformsppMulti(studentx, year, nominal){
    $("#formsppmulti").modal('show');
    $("#studenmx").val(studentx);
    $("#schoolyearmx").val(year);
    $("#costsppmx").val(nominal);
    $("#totcostsppmx").val(0);
}

function calFormSPP(){
   var cost  = $("#costspp").val();
   var tot   = $("#totpay").val();
   var refn  = parseInt(tot) - parseInt(cost);
   $("#refund").val(refn);
}

function calFormSPPML(){
   var cost  = $("#totcostsppmx").val();
   var tot   = $("#totpaymx").val();
   var refn  = parseInt(cost) - parseInt(tot);
   $("#refundmx").val(refn);
}


function calFormSPPMonth(){
   var start = $("#monthidmx").val();
   var end   = $("#emonthidmx").val();
   var cost  = $("#costsppmx").val();
   if(start > end){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Start Month More Then End Month</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#monthidmx").val(1);
        $("#emonthidmx").focus();
   }
   else{
      if(parseInt(start) == 1){
        var refn  = parseInt(cost) * parseInt(end);
      }
      else{
       var refn  = parseInt(cost) * ((parseInt(end) +1) - parseInt(start));
      }
       $("#totcostsppmx").val(refn);
       $("#totpaymx").val(0);
       $("#refundmx").val(0);
       $("#totpaymx").focus();
    }
}


function PaymentsppSaveMulti() {
    //e.preventDefault();
    var f_asal  = $("#f_paysppml");
    //var form    = getFormData(f_asal);
    var data    = $('#f_paysppml').serialize();
    //idx vlue
    var monthx    = $("#monthidmx").val();
    var emonthx   = $("#emonthidmx").val();
    var studentx  = $("#studenmx").val();
    var yearx     = $("#schoolyearmx").val();
    var costx     = $("#costsppmx").val();
    var tcostx    = $("#totcostsppmx").val();
    var payx      = $("#paytypemx").val();
    var totx      = $("#totpaymx").val();

    if(monthx == ""){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Start Month ID</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#monthidmx").focus();
    }
    else if(emonthx == ""){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert End Month ID</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#emonthidmx").focus();
    }
    else if(studentx == ""){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Student ID</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#studentmx").focus();
    }
    else if(yearx == ""){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert School Year</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#schoolyearmx").focus();
    }
    else if(costx == ""){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Cost SPP</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#costspp").focus();
    }
    else if(payx == ""){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Payment Type</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#paytype").focus();
    }
    else if(totx == "" || totx < tcostx){
        $("#notif-paysppml").show("slow");
        $('#notif-paysppml').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Total Paymant</div>');   
        $('#notif-paysppml').delay(2000).hide(2000);
        $("#totpaymx").focus();
    }
    else{
        blockForm("blokform");
        $.ajax({
            type: "POST",
            data: data,
            url : 'paymentspp/viewPaymentspp/savemulti', 
            success : function (data) {
                console.log(data.status);
                    if(data.status == 'ok') {
                        $('#formsppmulti').modal('toggle');
                        unblockForm("blokform");
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+data.msg+'</div>');
                        $('#notif-msg').delay(3000).hide(2000);
                        $('#cardsppheader').html(data.content); //replace content id cardsppheader
                        document.getElementById("f_paysppml").reset();

                    } 
                    else {
                        $("#notif-paysppml").show("slow");
                        unblockForm("blokform");
                        $('#notif-paysppml').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> '+data.msg+'</div>');
                        $('#notif-paysppml').delay(3000).hide(2000);
                    }
            }
        });

    }

    return false;
}




function PaymentsppSave() {
    //e.preventDefault();
    var f_asal  = $("#f_payspp");
    //var form    = getFormData(f_asal);
    var data  = $('#f_payspp').serialize();
    //idx vlue
    var monthx    = $("#monthid").val();
    var studentx  = $("#studenx").val();
    var yearx     = $("#schoolyear").val();
    var costx     = $("#costspp").val();
    var payx      = $("#paytype").val();
    var totx      = $("#totpay").val();

    if(monthx == ""){
        $("#notif-payspp").show("slow");
        $('#notif-payspp').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Month ID</div>');   
        $('#notif-payspp').delay(2000).hide(2000);
        $("#monthid").focus();
    }
    else if(studentx == ""){
        $("#notif-payspp").show("slow");
        $('#notif-payspp').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Student ID</div>');   
        $('#notif-payspp').delay(2000).hide(2000);
        $("#studentx").focus();
    }
    else if(yearx == ""){
        $("#notif-payspp").show("slow");
        $('#notif-payspp').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert School Year</div>');   
        $('#notif-payspp').delay(2000).hide(2000);
        $("#schoolyear").focus();
    }
    else if(costx == ""){
        $("#notif-payspp").show("slow");
        $('#notif-payspp').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Cost SPP</div>');   
        $('#notif-payspp').delay(2000).hide(2000);
        $("#costspp").focus();
    }
    else if(payx == ""){
        $("#notif-payspp").show("slow");
        $('#notif-payspp').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Payment Type</div>');   
        $('#notif-payspp').delay(2000).hide(2000);
        $("#paytype").focus();
    }
    else if(totx == "" || totx < costx){
        $("#notif-payspp").show("slow");
        $('#notif-payspp').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-info-circle"></i> Please Insert Total Paymant</div>');   
        $('#notif-payspp').delay(2000).hide(2000);
        $("#totpay").focus();
    }
    else{
        blockForm("blokform");
        $.ajax({
            type: "POST",
            data: data,
            url : 'paymentspp/viewPaymentspp/save', 
            success : function (data) {
                console.log(data.status);
                    if(data.status == 'ok') {
                        $('#formcardspp').modal('toggle');
                        unblockForm("blokform");
                        $("#notif-msg").show("slow");
                        $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><i class="fas fa-check"></i> '+data.msg+'</div>');
                        $('#notif-msg').delay(3000).hide(2000);
                        $('#cardsppheader').html(data.content); //replace content id cardsppheader
                        document.getElementById("f_payspp").reset();

                    } 
                    else {
                        $("#notif-payspp").show("slow");
                        unblockForm("blokform");
                        $('#notif-payspp').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fas fa-info-circle"></i> Failed To Save</div>');
                        $('#notif-payspp').delay(3000).hide(2000);
                    }
            }
        });

    }

    return false;
}


function PaymentsppDelete(studenx, monthx, yearx) {
    if (confirm('Are You Sure Delete..?')) {
        $.ajax({
            type: "GET",
            url: "paymentspp/viewPaymentspp/delete/"+studenx+"/"+monthx+"/"+yearx,
            success: function(response) {
                if (response.status == "ok") {
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-trash"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                    $('#cardsppheader').html(response.content); //replace content id cardsppheader
                } else if (response.status == "ok") {
                    $("#notif-msg").show("slow");
                    $('#notif-msg').fadeIn(2000).html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fas fa-times"></i> '+response.caption+' &nbsp;</div>');  
                    $('#notif-msg').delay(3000).hide(2000);
                    console.log('gagal');
                }
            }
        });
    }
    
    return false;
}



function printBill(url) {
    var base_url  = window.location.origin;
    return window.open(base_url+"/ci-spp"+url,'_blank', 'width=300');
}