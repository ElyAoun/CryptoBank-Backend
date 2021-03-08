<?php
require_once("dbh.class.php");
class Wallet_Type extends Dbh{
    public function  getWalletType($wallet_name)
    {
        $queryCryptoWalletTypeId = "SELECT * FROM wallet_type WHERE type_name=" . '\'' . $wallet_name . '\'';
        $res = $this->connect()->query($queryCryptoWalletTypeId);
        $this->closeConnection();
        return $res;
    }
    public function getSupportedWallets(){
        $wallet_query = "SELECT * FROM wallet_type";
        $wallet_res = $this->connect()->query($wallet_query);
        $this->closeConnection();
        return $wallet_res;
    }

    public function deleteWalletType($wallet_type_id)
    {
        $delete_query = "DELETE FROM wallet_type WHERE type_id =" . '\'' . $wallet_type_id. '\'';
        $result = $this->connect()->query($delete_query);
        $this->closeConnection();
        return $result;
    }

    public function insertWalletType($name,$symbol,$logo,$description)
    {
        $insert_query = "INSERT INTO wallet_type (type_name,type_symbol,type_logo,type_description) 
                         VALUES(" . '\'' . $name . '\'' . "," . '\'' . $symbol . '\'' . "," . '\''
                         . $logo . '\'' . "," . '"' . $description . '"'.")";
        $stmt = $this->connect()->query($insert_query);
        $this->closeConnection();
        return $stmt;
    }

    public function getTypeBySymbol($symbolCurrency)
    {
        $getType_query = "SELECT type_name FROM wallet_type WHERE type_symbol=" . '\'' . $symbolCurrency. '\'';
        $stmt = $this->connect()->query($getType_query);
        $this->closeConnection();
        return $stmt;
    }
}

?>