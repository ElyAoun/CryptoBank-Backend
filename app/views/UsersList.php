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
  <title>Users</title>
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

        <div class="table_container">
        <?php
        echo "<table>";
        echo "<thead><tr><th>ID</th><th>Name</th><th>email</th><th>Email</th><th>BirthDate</th><th>Action</th></tr></thead><tbody>";
        foreach ($_SESSION["userInfo"] as $k => $v) {
          echo "<tr><td>" . $v["user_id"] . "</td><td>" . $v["name"] 
               . "</td><td>" . $v["email"] . "</td><td>" . $v["email"] 
               . "</td><td>" . $v["birthdate"] . "</td><td>
               <a href=/cryptoBank/public/UserController/banUser/".$v["user_id"].">
               <Button class='action_container_ban'>
               ban
               <i class='fa fa-user-times'></i>
               </Button></a></td></tr>";
        }
        echo "</tbody></table>";
        ?>
        </div>
      </div>
    </main>
  </div>
</body>

</html>