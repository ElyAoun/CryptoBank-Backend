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
  <title>Messages</title>
  <?php require_once './main_components/header.php'; ?>
</head>

<body id="body">
  <div class="container">
    <?php require_once './main_components/navbar.php';
    require_once './main_components/sidebar.php';
    ?>

    <main>
      <div class="main__container">
        <?php require_once './main_components/cards.php';?>
        
        <div class="table_container">
        <?php
        echo "<table>";
        echo "<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Action</th></tr></thead><tbody>";
        foreach ($_SESSION["messages"] as $k => $v) {
          echo "<tr><td>" .$v["id"] ."</td><td>". $v["name"] . "</td><td>" . $v["email"] 
               . "</td><td>" . $v["message"]. "</td><td>
               <a href='/cryptoBank/app/views/ReplyMessage.php?ID=".$v["id"]."&email=".$v["email"]."'>
               <Button class='action_container_reply'>
               Reply
               <i class='fa fa-reply'></i>
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