<?php
class TransactionController extends Controller{
    private $TransactionModel=NULL;
    public function __construct(){
        $this->TransactionModel=$this->model('Transaction');
    }
    public function makeTransaction($wallet_sender_id, $wallet_receiver_id,$wallet_type_id,$wallet_address_sender,$wallet_address_receiver,$amount_sent_crypto,$amount_sent_us){
        $wallet_sender_id = $this->TransactionModel->connect()->real_escape_string($wallet_sender_id);
        $wallet_receiver_id = $this->TransactionModel->connect()->real_escape_string($wallet_receiver_id);
        $wallet_type_id = $this->TransactionModel->connect()->real_escape_string($wallet_type_id);
        $wallet_address_sender = $this->TransactionModel->connect()->real_escape_string($wallet_address_sender);
        $wallet_address_receiver = $this->TransactionModel->connect()->real_escape_string($wallet_address_receiver);
        $amount_sent_crypto = $this->TransactionModel->connect()->real_escape_string($amount_sent_crypto);
        $amount_sent_us = $this->TransactionModel->connect()->real_escape_string($amount_sent_us);
        $mysqldate =  date("Y:m:d H:i:s");
       if($this->TransactionModel->insertTransaction($wallet_sender_id, $wallet_receiver_id,$wallet_type_id,$wallet_address_sender,$wallet_address_receiver,$mysqldate,$amount_sent_crypto,$amount_sent_us)){
           return "true";
       }else
            return "false";
    }
    public function getSendTransactions(){
        $userid=$_SESSION["user_id"];
        $userid = $this->TransactionModel->connect()->real_escape_string($userid);
        $data_columns=$this->TransactionModel->getSendTransactions($userid);
        $json_Result=[];
        if($data_columns->num_rows!=0){
            $json_Result["error_type"]="found";
            while($row=$data_columns->fetch_assoc()){
                $json_Result["transactions"][]=$row;
            }
        }else
            $json_Result["error_type"]="not found";
        return json_encode($json_Result);
    }
    public function getReceiverTransactions(){
        $userid=$_SESSION["user_id"];
        $userid = $this->TransactionModel->connect()->real_escape_string($userid);
        $data_columns=$this->TransactionModel->getReceiveTransactions($userid);
        $json_Result=[];
        if($data_columns->num_rows!=0){
            $json_Result["error_type"]="found";
            while($row=$data_columns->fetch_assoc()){
                $json_Result["transactions"][]=$row;
            }
        }else
            $json_Result["error_type"]="not found";
        return json_encode($json_Result);
    }
    public function getTransactions(){
        $json_send_transactions=$this->getSendTransactions();
        $json_receive_transactions=$this->getReceiverTransactions();
        $results["send"]=json_decode($json_send_transactions);
        $results["receive"]= json_decode($json_receive_transactions);
        return json_encode($results);
    }

}
?>