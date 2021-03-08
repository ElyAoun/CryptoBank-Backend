<?php
require_once("dbh.class.php");
class Wallet extends Dbh
{
    public function insertWallet($userid, $crypId, $wall_addr, $balance, $date)
    {
        $insertQuery = "INSERT INTO wallet (user_id_fk,wallet_type_fk,wallet_address,balance,creation_date) VALUES (" . '\'' . $userid . '\'' . "," . '\'' . $crypId . '\'' . "," . '\'' . $wall_addr . '\'' . "," . '\'' . $balance . '\'' . "," . '\'' . $date . '\'' . ")";
        $wallet_res = $this->connect()->query($insertQuery);
        $this->closeConnection();
        return $wallet_res;
    }

    public function getWalletByType($userid, $wallet_type_name)
    {
        $wallet_query = "SELECT * FROM wallet WHERE user_id_fk=" . '\'' . $userid . '\'' . " AND wallet_type_fk= (SELECT type_id FROM wallet_type WHERE type_name = " . '\'' . $wallet_type_name . '\'' . ")";
        $wallet_res = $this->connect()->query($wallet_query);
        $this->closeConnection();
        return $wallet_res;
    }

    public function getWalletByAddress($address, $wallet_type_fk)
    {
        $wallet_query = "SELECT * FROM wallet WHERE wallet_address=" . '\'' . $address . '\'' . " AND wallet_type_fk =" . '\'' . $wallet_type_fk . '\''; //get the wallet by precising the address and same type of wallet
        $wallet_res = $this->connect()->query($wallet_query);
        $this->closeConnection();
        return $wallet_res;
    }
    public function updateWalletAmount($walletid, $amount)
    {
        $wallet_query = "UPDATE wallet SET balance= " . '\'' . $amount . '\'' . " WHERE wallet_id =" . '\'' . $walletid . '\'';
        $wallet_res = $this->connect()->query($wallet_query);
        $this->closeConnection();
        return $wallet_res;
    }
    public function updateWalletAddress($walletid)
    {   $hex_address=$this->getHexAddress();
        $wallet_query = "UPDATE wallet SET wallet_address=" . '\'' . $hex_address . '\'' . " WHERE wallet_id =" . '\'' . $walletid . '\'';
        $wallet_res = $this->connect()->query($wallet_query);
        $this->closeConnection();
        return $wallet_res;
    }
    public function getWalletOfUser($userid)
    {
        $queryGetWallets = "SELECT * FROM wallet JOIN wallet_type ON wallet_type_fk=wallet_type.type_id WHERE user_id_fk=" . '\'' . $userid . '\'';
        $wallet_res = $this->connect()->query($queryGetWallets);
        $this->closeConnection();
        return $wallet_res;
    }
    public function DeleteWallet($userid, $wallet_name)
    {
        $queryDeleteWallet = "DELETE FROM wallet WHERE wallet_id=(SELECT wallet_id WHERE user_id_fk='" . $userid . "' AND wallet_type_fk=(SELECT type_id FROM wallet_type WHERE type_name='" . $wallet_name . "'))";
        $wallet_res = $this->connect()->query($queryDeleteWallet);
        $this->closeConnection();
        return $wallet_res;
    }
    public function getHexAddress(){
        $python_executer_path="C:/Users/Elie/Python/Python38/python.exe";
        $command = escapeshellcmd($python_executer_path." ../../cryptoBank/python_generate_addr.py");
        $hex_address= shell_exec($command);
        return $hex_address;
    }
    public function getWalletAddress($userid,$wallet_name){
        $wallet_query = "SELECT wallet_address FROM wallet WHERE user_id_fk=" . '\'' . $userid . '\''." AND wallet_type_fk=(SELECT type_id FROM wallet_type WHERE type_name=".'\''.$wallet_name.'\''.")";
        $wallet_res = $this->connect()->query($wallet_query);
        $this->closeConnection();
        return $wallet_res;
    }
}
?>