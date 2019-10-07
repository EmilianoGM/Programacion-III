<?php
require_once("./clases/Usuario.php");
if(isset($_GET["email"])){
    $email = $_GET["email"];
    $email = str_replace(".", "_", $email);
    if(isset($_COOKIE[$email])){
        var_dump($_COOKIE);
    }else{
        echo "error Cookie";
    }
} else{
    echo "error email";
}
?>