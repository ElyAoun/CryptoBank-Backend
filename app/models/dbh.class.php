<?php
class Dbh{
    private $servername="localhost";
    private $username="root";
    private $password="";
    private $dbname="cryptobank";
    private $isConnected=false;
    private $mysqliConnect;
    public function connect(){
        $this->mysqliConnect=new mysqli($this->servername,$this->username,$this->password,$this->dbname) or die("Could not connect");
        $this->isConnected=true;
        return $this->mysqliConnect;
    }
    public function closeConnection(){
        if($this->isConnected){
            $this->mysqliConnect->close();
            $this->isConnected=false;
        }
    }
}
?>