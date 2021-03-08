$("#password_error_message").hide();
$("#confirm_password_error_message").hide();

var regExp = /[_\-!\"@;,.:$%#&*()^]/;
var can_submit = false;
var check_pass = false;

function check() {
  var password_length = $("#form_password").val().length;
  if (password_length < 8) {
    $("#password_error_message").html("minimum 8 characters");
    $("#password_error_message").show();
    can_submit = false;
  } else if (!regExp.test($("#form_password").val())) {
    $("#password_error_message").html("password should contain symbols");
    $("#password_error_message").show();
    can_submit = false;
  } else {
    $("#password_error_message").hide();
    can_submit = true;
  }
  if ($("#form_password").val() == $("#form_confirmpassword").val()) {
    $("#confirm_password_error_message").hide();
    check_pass = true;
  } else {
    $("#confirm_password_error_message").html("password doesn't match");
    $("#confirm_password_error_message").show();
    check_pass = false;
  }
}
function check_confirm() {
  if ($("#form_password").val() == $("#form_confirmpassword").val()) {
    $("#confirm_password_error_message").hide();
    check_pass = true;
  } else {
    $("#confirm_password_error_message").html("password doesn't match");
    $("#confirm_password_error_message").show();
    check_pass = false;
  }
}
$(document).ready(function() {
    //option A
    $("form").submit(function(e){
        if (!(can_submit && check_pass)) {
            e.preventDefault();
        }
    });
});