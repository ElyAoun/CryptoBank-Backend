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
  <title>Currencies</title>
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
        <a href="/cryptoBank/public/AddCurrency"><Button class="add-admin">Add Currency</Button></a>
        <div class="table_container">
          <?php
          echo "<table>";
          echo "<thead><tr><th>ID</th><th>Name</th><th>Symbol</th><th>Logo</th><th colspan='2'>Actions</th></tr></thead><tbody>";
          foreach ($_SESSION["currenciesInfo"] as $k => $v) {
            echo "<tr><td>" . $v["type_id"] . "</td><td><img width=50 height=50 src='data:image/png;base64,".base64_encode($v['type_logo'])."'/></td>
              <td>" . $v["type_symbol"] . "</td><td>".$v["type_name"]."</td><td>
               <a href='/cryptoBank/public/Wallet_TypeController/removeCurrency/" . $v["type_id"] . "'>
               <Button class='action_container_delete'>
               Delete
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