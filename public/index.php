<?php
require_once '../app/init.php';  //core
$postParameters=[];  //array to store POST parameters for the methods.
foreach($_POST as $key=>$value){
    $postParameters[$key]=$value;  //put POST args in the array if they exist
}
if(isset($postParameters["session_id"])){//works for android only since i provide session id
    session_id($postParameters["session_id"]);
    unset($postParameters["session_id"]);
}
session_start();
$app = new App($postParameters);
?>
