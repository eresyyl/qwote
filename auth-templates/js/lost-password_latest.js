$(document).ready(function() {
  
  $(".try_again").click(function(){
    $("#check-pincode").hide();
    $("#lost-password").fadeIn();
  });

  $("#go-lost-password").click(function(){
    $("#go-lost-password").html("<i class='fa fa-refresh fa-spin'></i>");
    var send_pin = "/wp-content/themes/go/auth-templates/ajax/send_pin.php";
    //var user_email = $('input[name=user_login');
    jQuery.ajax({
      url: send_pin,
      type: "POST",
      dataType: "json",
      cache: false,
      data: jQuery("#lost-password").serialize(),
      success: function(response) {
        $("#lost-password-response").html("");
        $("#go-lost-password").html("Sent PIN-code");
        if(response.status == 'notfound') {
          $("#lost-password-response").html(response.message);
        }
        else if(response.status == 'fail') {
          $("#lost-password-response").html(response.message);
        }
        else if(response.status == 'success') {
          $('input[name=user_id').val(response.user_id);
          $("#lost-password").hide();
          $("#check-pincode").fadeIn();
        }
        else {
          $("#lost-password-response").html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
        }
      },
      error: function(response) {
        $("#go-lost-password").html("Sent PIN-code");
        $("#lost-password-response").html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
      }
    });
  });

  $("#go-check-pincode").click(function(){
    $("#go-check-pincode").html("<i class='fa fa-refresh fa-spin'></i>");
    var check_pin = "/wp-content/themes/go/auth-templates/ajax/check_pin.php";
    jQuery.ajax({
      url: check_pin,
      type: "POST",
      dataType: "json",
      cache: false,
      data: jQuery("#check-pincode").serialize(),
      success: function(response) {
        $("#check-pincode-response").html("");
        $("#go-check-pincode").html("Submit");
        if(response.status == 'fail') {
          $("#check-pincode-response").html(response.message);
        }
        else if(response.status == 'success') {
          $('input[name=pin').val(response.pin);
          $("#check-pincode").hide();
          $("#change-pass").fadeIn();
        }
        else {
          $("#check-pincode-response").html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
        }
      },
      error: function(response) {
        $("#go-check-pincode").html("Submit");
        $("#check-pincode-response").html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
      }
    });
  });

  $("#go-change-pass").click(function(){
    $("#go-change-pass").html("<i class='fa fa-refresh fa-spin'></i>");
    var change_pass = "/wp-content/themes/go/auth-templates/ajax/change_pass.php";
    jQuery.ajax({
      url: change_pass,
      type: "POST",
      dataType: "json",
      cache: false,
      data: jQuery("#change-pass").serialize(),
      success: function(response) {
        $("#change-pass-response").html("");
        $("#go-change-pass").html("Submit");
        if(response.status == 'fail') {
          $("#change-pass-response").html(response.message);
        }
        else if(response.status == 'success') {
          $('.hide-on-success').hide();
          $("#change-pass-response").html("<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Password changed! Now you can <a href='http://www.renovar.co.nz/sign-in'>Sign in</a>...</div>");
          //setTimeout(function(){ window.location.replace("http://www.renovar.co.nz/sign-in"); },2000);

        }
        else {
          $("#change-pass-response").html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
        }
      },
      error: function(response) {
        $("#go-change-pass").html("Submit");
        $("#change-pass-response").html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
      }
    });
  });
  
});