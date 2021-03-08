<?php
session_start();
if (!isset($_SESSION["isLogged"])) {
    header("Location:/cryptoBank/public");
}
if (isset($_SESSION["message_display"])) {
    echo $_SESSION["message_display"];
    unset($_SESSION["message_display"]);
}
$json = file_get_contents('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=11c5c6d8-2f77-4f86-add2-47241f13fb44');
$obj = json_decode($json);
$curr_arr = $obj->data;
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Currency</title>
    <link rel="stylesheet" href="/cryptoBank/css/addCurrency.css">
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>

<body>
    <div class="container">
        <div class="left">
            <img class="btcImage" src="/cryptoBank/images/btcLogo.png" />
            <h2>Add Currency</h2>
        </div>
        <div class="right">
            <div class="formBox">
                <form action="/cryptoBank/public/Wallet_TypeController/addCurrency" method="POST" enctype="multipart/form-data">
                    <p>Name</p>
                    <select name="nameCurrency" id=form_name onchange="setCryptoSymbol();"></select>
                    <p>Symbol</p>
                    <input type="text" name="symbolCurrency" id="form_symbol" readonly>
                    <p>Logo</p>
                    <input type="file" name="logoCurrency" id="form_logo" required>
                    <p>Description</p>
                    <textarea name="descriptionCurrency" cols="40" rows="6" required></textarea>
                    <input type="submit" id="submitbtn" value="Add">
                </form>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    var curr_cryps =<?php echo json_encode($curr_arr)?>;
    var sel = document.getElementById('form_name');
    var input_symbol=document.getElementById("form_symbol");
    for (let i = 0; i < 25; i++) {
        var opt = document.createElement('option');
        opt.appendChild(document.createTextNode(curr_cryps[i].name));
        opt.value = curr_cryps[i].name;
        sel.appendChild(opt);
    }
    input_symbol.value=curr_cryps[sel.selectedIndex].symbol;
    function setCryptoSymbol(){
        input_symbol.value=curr_cryps[sel.selectedIndex].symbol;
    }
</script>

</html>