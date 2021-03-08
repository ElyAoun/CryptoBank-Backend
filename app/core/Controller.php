<?php
class Controller {

  public function model($model){
    require_once '../app/models/'.$model.'.php';
    return new $model();
  }

  public function view($view,$message=''){
    $_SESSION["message_display"]=$message;
    $this->cardVariables();  //update card values after changing the view
    header("Location: /cryptoBank/app/views/".$view.".php");
  }

  
  public function validate_email($str)
  {
      $email_pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/";
      return preg_match($email_pattern, $str);
  }
  
  public function validate_password($str)
  {
      $min_len = 6;
      if (strlen($str) >= $min_len && preg_match('/[A-Z]/', $str) && preg_match('/[a-z]/', $str) && preg_match('/\d/', $str) && !preg_match('/\s/', $str)) {
          return true;
      } else return false;
  }
  public function cardVariables()
    {
        $nbrOfAdmins = $this->model('User')->getUsers('1')->num_rows;
        $nbrOfUsers = $this->model('User')->getUsers('0')->num_rows;
        $nbrOfMessages = $this->model('Message')->getNbrMessages()->num_rows;
        $nbrOfRepliedMessage = $this->model('Message')->getNbrRepliedMessages()->num_rows;
        $nbrOfCurrencies = $this->model('Wallet_Type')->getSupportedWallets()->num_rows;

        $_SESSION["nbrOfAdmins"] = $nbrOfAdmins;
        $_SESSION["nbrOfUsers"] = $nbrOfUsers;
        $_SESSION["nbrOfMessages"] = $nbrOfMessages;
        $_SESSION["nbrOfRepliedMessages"] = $nbrOfRepliedMessage;
        $_SESSION["nbrOfCurrencies"] = $nbrOfCurrencies;
    }
  
}
?>