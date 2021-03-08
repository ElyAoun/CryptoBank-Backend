<?php
require_once("dbh.class.php");
class Transaction extends Dbh
{
    public function insertTransaction($wallet_sender_id, $wallet_receiver_id,$wallet_type_id,$wallet_address_sender,$wallet_address_receiver,$mysqldate,$amount_sent_crypto,$amount_sent_us)
    {
        $insertTransactionQuery = "INSERT INTO transaction (wallet_id_sender,wallet_id_receiver,wallet_type_id,wallet_address_sender,wallet_address_receiver,date,amount_crypto,amount_us) VALUES(".'\''.$wallet_sender_id.'\''.",".'\''.$wallet_receiver_id.'\''.",".'\''.$wallet_type_id.'\''.",".'\''.$wallet_address_sender.'\''.",".'\''.$wallet_address_receiver.'\''.",".'\''.$mysqldate.'\''.",".'\''.$amount_sent_crypto.'\''.",".'\''.$amount_sent_us.'\''.")";
        $stmt=$this->connect()->query($insertTransactionQuery);
        $this->closeConnection();
        return $stmt;
    }

    public function getSendTransactions($userid)
    {
        $selectQuery="SELECT wallet_address_sender,wallet_address_receiver,date,amount_crypto,amount_us,type_symbol FROM transaction JOIN wallet_type ON wallet_type_id=wallet_type.type_id WHERE wallet_id_sender IN (SELECT wallet_id FROM wallet WHERE user_id_fk=".$userid.")";
        $stmt=$this->connect()->query($selectQuery);
        $this->closeConnection();
        return $stmt;
    }

    public function getReceiveTransactions($userid)
    {
        $selectQuery="SELECT wallet_address_sender,wallet_address_receiver,date,amount_crypto,amount_us,type_symbol FROM transaction JOIN wallet_type ON wallet_type_id=wallet_type.type_id WHERE wallet_id_receiver IN (SELECT wallet_id FROM wallet WHERE user_id_fk=".$userid.")";
        $stmt=$this->connect()->query($selectQuery);
        $this->closeConnection();
        return $stmt;
    }
}
?>