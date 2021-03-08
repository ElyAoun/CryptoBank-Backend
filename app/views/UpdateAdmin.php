<?php
session_start();
if (!isset($_SESSION["isLogged"])) {
  header("Location:/cryptoBank/public");
}
if(isset($_SESSION["message_display"])){
  echo $_SESSION["message_display"];
  unset($_SESSION["message_display"]);   
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Change Password</title>
  <?php require_once './main_components/header.php'; ?>
</head>

<body id="body">
  <div class="container">
    <?php require_once './main_components/navbar.php';
    require_once './main_components/sidebar.php';
    ?>

    <main>
      <div class="main__container">
        <?php require_once './main_components/cards.php'; ?>
        <form class="update-form" action="/cryptoBank/public/AdminController/editAdmin/" method="POST">
          <p>Current Password :</p> <input type="password" name="oldPasswordAdmin" /><br>
          <p>New Password :</p> <input type="password" id="form_newPassword" name="newPasswordAdmin" /> <br>
          <span class="error-form" id="password_error_message"></span>
          <input type="submit" value="Update">
        </form>
      </div>
    </main>
  </div>
</body>

</html>