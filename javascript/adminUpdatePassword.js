$(function() {
    $("#password_error_message").hide();
    $('form').submit(function(e){
        if(check_newPassword()){
            e.preventDefault();
        }
    })
    function check_newPassword() {
        var password_length = $("#form_newPassword").val().length;
        var regExp = /[_\-!\"@;,.:$%#&*()^]/;
        var error_password=false;
        if(password_length < 8) {
            $("#password_error_message").html("Minimum 8 characters");
            $("#password_error_message").show();
            error_password = true;
        }
        else if(!regExp.test($('#form_newPassword').val())){
            $("#password_error_message").html("Password should contain symbols");
            $("#password_error_message").show();
            error_password = true;
        } else {
            $("#password_error_message").hide();
            error_password=false;
        }
        return error_password;
    }
});