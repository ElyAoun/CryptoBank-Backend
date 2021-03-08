<?php
class WalletController extends Controller
{
    private $WalletModel = NULL;
    private $Wallet_TypeModel=NULL;
    public function __construct()
    {
        $this->WalletModel = $this->model('Wallet');
        $this->Wallet_TypeModel=$this->model('Wallet_Type');
    }
    public function sendMoney($walletName, $amount_crypto, $amount_us, $receiveAddress)
    {
        $userid = $_SESSION["user_id"];
        $result_json = [];
        if (!empty($userid) && !empty($walletName) && !empty($amount_crypto) && !empty($amount_us) && !empty($receiveAddress)) {
            $userid = htmlspecialchars($userid);
            $walletName = htmlspecialchars($walletName);
            $amount_crypto = htmlspecialchars($amount_crypto);
            $amount_us = htmlspecialchars($amount_us);
            $receiveAddress = htmlspecialchars($receiveAddress);

            $userid = $this->WalletModel->connect()->real_escape_string($userid);
            $walletName = $this->WalletModel->connect()->real_escape_string($walletName);
            $amount_crypto = $this->WalletModel->connect()->real_escape_string($amount_crypto);
            $amount_us = $this->WalletModel->connect()->real_escape_string($amount_us);
            $receiveAddress = $this->WalletModel->connect()->real_escape_string($receiveAddress);

            $stmt = $this->checkExistingWallet($userid, $walletName);
            if ($stmt->num_rows != 0) { //if the chosen wallet exists in the user's wallet
                $data_columns_wallet_sender = $stmt->fetch_assoc(); //get all attributes of the selected wallet
                $balance = $data_columns_wallet_sender["balance"]; //get its balance
                $balance_double = doubleval($balance);
                $amount_double = doubleval($amount_crypto); //get the amount to send
                //get the receiver wallet
                $stmt2 = $this->WalletModel->getWalletByAddress($receiveAddress, $data_columns_wallet_sender["wallet_type_fk"]);
                if ($stmt2->num_rows != 0 && $balance_double >= $amount_double) { //if the balance of sender is enough
                    $rest_amount = $balance_double - $amount_double;
                    //updating sender wallet balance
                    $stmt3 = $this->WalletModel->updateWalletAmount($data_columns_wallet_sender["wallet_id"], $rest_amount);
                    $data_columns_wallet_receiver = $stmt2->fetch_assoc();
                    //update the balance of receiver wallet
                    $new_balance_receiver = doubleval($data_columns_wallet_receiver["balance"]) + $amount_double;
                    $stmt4 = $this->WalletModel->updateWalletAmount($data_columns_wallet_receiver["wallet_id"], $new_balance_receiver);
                    //generate another address for the receiver wallet
                    $this->WalletModel->updateWalletAddress($data_columns_wallet_receiver["wallet_id"]);
                    $wallet_sender_id = $data_columns_wallet_sender["wallet_id"];
                    $wallet_receiver_id = $data_columns_wallet_receiver["wallet_id"];
                    $wallet_type_id = $data_columns_wallet_sender["wallet_type_fk"];
                    $wallet_address_sender = $data_columns_wallet_sender["wallet_address"];
                    $wallet_address_receiver = $data_columns_wallet_receiver["wallet_address"];
                    require_once("../app/controllers/TransactionController.php");
                    $transactionController = new TransactionController();
                    $result_json["error_type"] = $transactionController->makeTransaction($wallet_sender_id, $wallet_receiver_id, $wallet_type_id, $wallet_address_sender, $wallet_address_receiver, $amount_crypto, $amount_us);
                } else {
                    if (!($balance_double >= $amount_double)) {
                        $result_json["error_type"] = "Insufficent balance";
                    } else {
                        $result_json["error_type"] = "Receiver Wallet doesn't exist";
                    }
                }
            } else
                $result_json["error_type"] = "You don't have the current wallet";
        } else $result_json["error_type"] = "false";
        return json_encode($result_json);
    }
    public function addWallet($cryptoName)
    {
        $result_json = [];
        $userid = $_SESSION["user_id"];
        if (!empty($userid) && !empty($cryptoName)) {
            $userid = htmlspecialchars($userid);
            $cryptoName = htmlspecialchars($cryptoName);

            $userid = $this->WalletModel->connect()->real_escape_string($userid);
            $cryptoName = $this->WalletModel->connect()->real_escape_string($cryptoName);

            $data_columns = $this->Wallet_TypeModel->getWalletType($cryptoName)->fetch_assoc();
            $crypId = $data_columns["type_id"];
            $result_wallet_exist_query = $this->WalletModel->getWalletByType($userid, $data_columns["type_name"]);
            if ($result_wallet_exist_query->num_rows != 0) { //check if the user already have the wallet
                $result_json["error_type"] = "Wallet Exist";
            } else {
                $d = getdate();
                $timestamp = strtotime($d["year"] . "/" . $d["mon"] . "/" . $d["mday"]);
                $mysqldate =  date("Y-m-d", $timestamp);
                $balance = 0.01;
                $wall_addr = $this->WalletModel->getHexAddress();
                $res = $this->WalletModel->insertWallet($userid, $crypId, $wall_addr, $balance, $mysqldate);
                if ($res) {
                    $result_json["error_type"] = "true";
                } else $result_json["error_type"] = "false";
            }
        }
        return json_encode($result_json);
    }
    public function getWallets()
    {
        $userid = $_SESSION["user_id"];
        $response = array();
        if (!empty($userid)) {
            $userid = htmlspecialchars($userid);
            $userid = $this->WalletModel->connect()->real_escape_string($userid);
            $data_columns = $this->WalletModel->getWalletOfUser($userid);
            $response["success"] = 1;
            while($row=$data_columns->fetch_assoc()){
                $row["type_logo"]=base64_encode($row["type_logo"]);
                $response["wallets"][] = $row;
            }
        } else {
            $response["success"] = 0;
        }
        $jsonArray = json_encode($response);
        return $jsonArray;
    }
    public function DeleteWallet($wallet_name)
    {
        $userid = $_SESSION["user_id"];
        $response = array();
        if (!empty($userid) && !empty($wallet_name)) {
            $userid = htmlspecialchars($userid);
            $wallet_name = htmlspecialchars($wallet_name);

            $userid = $this->WalletModel->connect()->real_escape_string($userid);
            $wallet_name = $this->WalletModel->connect()->real_escape_string($wallet_name);

            $result = $this->WalletModel->DeleteWallet($userid, $wallet_name);
            if ($result) {
                $response["success"] = 1;
            } else $response["success"] = 0;
        } else $response["success"] = 0;
        return json_encode($response);
    }
    
    public function getWalletAddress($wallet_name)
    {
        $userid = $_SESSION["user_id"];
        $userid = $this->WalletModel->connect()->real_escape_string($userid);
        $wallet_name = $this->WalletModel->connect()->real_escape_string($wallet_name);
        $wallet_address = $this->WalletModel->getWalletAddress($userid, $wallet_name);
        $result = [];
        if ($wallet_address->num_rows != 0 && !empty($userid)) {
            $walletAddress = $wallet_address->fetch_assoc();
            $result["wallet_address"] = $walletAddress["wallet_address"];
            $result["success"] = 1;
        } else $result["success"] = 0;
        return json_encode($result);
    }
    public function checkExistingWallet($userid,$walletName){
        $userid = $this->WalletModel->connect()->real_escape_string($userid);
        $walletName = $this->WalletModel->connect()->real_escape_string($walletName);

        $stmt= $this->WalletModel->getWalletByType($userid, $walletName);
        return $stmt;
    }
}
?>
