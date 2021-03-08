<?php
session_start();
if (!isset($_SESSION["isLogged"])){
    header("Location:/cryptoBank/public");
}
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="/cryptoBank/css/register.css">
    <script  src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" language="javascript" src="/cryptoBank/javascript/adminRegform.js"></script>
</head>

<body>
    <div class="container">
        <div class="left">
            <img class="btcImage" src="/cryptoBank/images/btcLogo.png" />
            <h2>Add Admin</h2>
        </div>
        <div class="right">
            <div class="formBox">
                <form id="adminRegForm" action="/cryptoBank/public/AdminController/adminRegister" method="POST">
                    <p>Name</p>
                    <input type="text" name="nameAdmin" id="form_name" required>
                    <p>Email</p>
                    <input type="email" name="emailAdmin" id="form_email" required>
                    <p>Password</p>
                    <input type="password" name="passwordAdmin" id="form_password" required onkeyup="check();">
                    <span class="error_form" id="password_error_message"></span>
                    <p>Confirm password</p>
                    <input type="password" name="confirmpasswordAdmin" id="form_confirmpassword" required onkeyup="check_confirm();">
                    <span class="error_form" id="confirm_password_error_message"></span>
                    <p>Date of Birth</p>
                    <input type="date" name="dob" id="form_date" required>
                    <input type="submit" id="submitbtn" value="Create Admin" >
                </form>
            </div>
        </div>
    </div>
</body>

</html>
