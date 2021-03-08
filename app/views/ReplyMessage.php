<?php
session_start();
if (!isset($_SESSION["isLogged"])) {
  header("Location:/cryptoBank/public");
}
?>

<html>
    <head>
        <title>Reply</title>
        <link rel="stylesheet" href="/cryptoBank/css/replyMessage.css" />
    </head>
    <body>
        <div class="replyForm">
        <p>To:</p> <input type="email" name="destination"  value="<?php echo $_GET['email']; ?>" readonly/><br>
        <p>Message:</p><textarea rows='8'></textarea><br>
        <?php
        echo "<a href='/cryptoBank/public/MessageController/sendReply/".$_GET['ID']."'><input type='submit' value='Reply'></a>";
        ?>
        </div>
    </body>
</html>
