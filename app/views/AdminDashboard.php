<?php
session_start();
if(!isset($_SESSION["isLogged"])){
  header("Location:/cryptoBank/public");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include '../views/main_components/header.php'; ?>
  <title>Home</title>
</head>
<body id="body">
    <div class="container">
      <?php include '../views/main_components/navbar.php';
            include '../views/main_components/sidebar.php';
      ?>

      <main>
        <div class="main__container">
          <?php include '../views/main_components/cards.php'; ?>
          <div class="table_container"></div>
        </div>
      </main>
    </div>
  </body>
</html>

