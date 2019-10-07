<?php
require_once("./clases/Usuario.php");
$objRetorno = new stdClass();
if(isset($_POST["email"]) && isset($_POST["clave"])){
    $email = $_POST["email"];
    $clave = $_POST["clave"];
    $nuevoUsuario = new Usuario($email, $clave);
    $flag = Usuario::VerificarExistencia($nuevoUsuario);
    if($flag){
        setcookie($email, date("H:i:s"));
        header('Location: ./ListadoUsuarios.php');
    }
    //var_dump($_COOKIE);
}
?>