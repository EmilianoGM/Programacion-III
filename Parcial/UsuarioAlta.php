<?php
require_once("./clases/Usuario.php");
if(isset($_POST["email"]) && isset($_POST["clave"])){
    $email = $_POST["email"];
    $clave = $_POST["clave"];
    $nuevoUsuario = new Usuario($email, $clave);
    $objRetorno = $nuevoUsuario->GuardarEnArchivo();
    var_dump($objRetorno);
} else {
    echo "Error";
}
?>