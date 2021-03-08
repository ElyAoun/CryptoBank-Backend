<?php
require_once("dbh.class.php");
class Message extends Dbh
{
    public function insertMessage($message, $user_id)
    {
        $insertQuery = "INSERT INTO message (message,user_id,replied) VALUES (" . '\'' . $message . '\'' . "," . '\'' . $user_id . '\'' . "," . "false)";
        $stmt = $this->connect()->query($insertQuery);
        $this->closeConnection();
        return $stmt;
    }

    public function getMessages(){
        $messageQuery = "SELECT id,message,name,email from message JOIN user WHERE message.user_id = user.user_id AND replied=false";
        $stmt = $this->connect()->query($messageQuery);
        $this->closeConnection();
        return $stmt;
    }

    public function updateMessageStatus($messageID){
        $updateMessageQuery = "UPDATE message SET replied = true WHERE id =".'\''.$messageID.'\'';
        $stmt = $this->connect()->query($updateMessageQuery);
        $this->closeConnection();
        return $stmt;
    }

    public function getNbrMessages(){
        $nbrMessagesQuery = "SELECT * FROM message WHERE replied=false";
        $stmt = $this->connect()->query($nbrMessagesQuery);
        $this->closeConnection();
        return $stmt;
    }

    public function getNbrRepliedMessages(){
        $nbrRepliedMessagesQuery = "SELECT * FROM message WHERE replied=true";
        $stmt = $this->connect()->query($nbrRepliedMessagesQuery);
        $this->closeConnection();
        return $stmt;
    }

}
?>
