<?php
class App
{

  protected $controller = 'AdminController'; //default

  protected $method = 'index'; //default


  public function __construct($postArray)
  {
    $url = $this->parseUrl();  //explode $_GET['url']  which is everything after public/ 

    if (file_exists('../app/controllers/' . $url[0] . '.php')) {
      $this->controller = $url[0]; 
      unset($url[0]);
    }

    require_once '../app/controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller; //to create instance for $this->controller

    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {  //to check if the method exists in the controller
        $this->method = $url[1];
        unset($url[1]);
      }
    }
    if(empty($postArray)){//if we didnt do form submission with post check for arguments in the url
      $postArray =$url ?  array_values($url) : [];  //$postArray will contain the url with the arguments after the method
    }
    $res = call_user_func_array([$this->controller, $this->method], $postArray); //take the values of $postArray after the method as arguments.
    if ($this->isJson($res)){
      header("Content-type: application/json");
      include "../app/views/Android/print.php";  //print json message
    }
  }

  public function parseUrl()
  {
    if (isset($_GET['url'])) {  //after public/
      return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)); //FILTER_SANITIZE_URL remove all the illegal characters from the url
    }//example if /public/AdminController/adminLogin => url[0] = AdminController and url[1] = adminLogin
  }
  private function isJson($string)
  {
    json_decode($string);   
    return (json_last_error() == JSON_ERROR_NONE);//returns true if $string is json (if json can decode $string);
  }
}
?>