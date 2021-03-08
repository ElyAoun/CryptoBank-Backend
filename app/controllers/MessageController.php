<?php

class MessageController extends Controller
{
    private $MessageModel = NULL;
    public function __construct()
    {
        $this->MessageModel = $this->model('Message');
    }
    public function sendMessage($message)
    {
        $userid = $_SESSION["user_id"];
        $result_json = [];
        if (isset($message) && isset($userid)) {
            
            $userid = $this->MessageModel->connect()->real_escape_string($userid);
            $message = $this->MessageModel->connect()->real_escape_string($message);
        
            $stmt = $this->MessageModel->insertMessage($message, $userid);
            if ($stmt) {
                $result_json["error_type"] = "true";
            } else {
                $result_json["error_type"] = "false";
            }
        }
        $_SESSION["nbrOfMessages"] = $this->MessageModel->getNbrMessages()->num_rows;
        return json_encode($result_json);
    }

    public function displayMessages($args = [])
    {
        $messages = array();
        $data = $this->MessageModel->getMessages();

        while ($row = $data->fetch_assoc()) {
            $messages[] = $row;
        }
        $_SESSION["messages"] = $messages;
        if (count($args) == 1)
            $this->view('MessagesList', $args[0]);
        else $this->view('MessagesList');
    }

    public function sendReply($messageID)
    {
        $messageID = $this->MessageModel->connect()->real_escape_string($messageID);
        $reply = $this->MessageModel->updateMessageStatus($messageID);
        if ($reply) {
            $_SESSION["nbrOfMessages"] = $this->MessageModel->getNbrMessages()->num_rows;
            $_SESSION["nbrOfRepliedMessages"] = $this->MessageModel->getNbrRepliedMessages()->num_rows;
            $this->displayMessages(["<script type=text/javascript>alert('Reply successfully sent');</script>"]);
        } else
            $this->view("ReplyMessage", "<script> alert('Reply failed'); </script>");
    }
}
?>