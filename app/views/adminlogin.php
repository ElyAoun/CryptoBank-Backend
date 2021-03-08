<?php
    session_start();
    if(isset($_SESSION["message_display"])){
        echo $_SESSION["message_display"];
        unset($_SESSION["message_display"]);   
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="/cryptoBank/css/login.css">
        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    </head>
    <body>
        <div class="title">
            <h2>CRYPTOBANK</h2>
        </div>
        <div class="container">
            <div class="left">
                <img class="btcImage" src="/cryptoBank/images/btcLogo.png"/>
            </div>
            <div class="right">
                <div class="formBox">
                    <form method=POST action="/cryptoBank/public/AdminController/adminLogin">
                        <p>Email</p>
                        <input type="email" id="form_email" name="email">
                        <p>Password</p>
                        <input type="password" id="form_password" name="password">
                        <input type="submit" id = "submit" value="Sign in">
                        <span class="emptyFields" id="invalid_error_message"></span>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

