<?php
require_once "./usuario.php";
require_once "./AccesoDatos.php";

$user = isset($_POST["usuario"]) ? $_POST["usuario"] : NULL;
if($user != NULL){
    $obj = json_decode($user);
    $clave = $obj->clave;
    $correo = $obj->correo;
    $objRespuesta = Usuario::ExisteEnDB($clave, $correo);
    if($objRespuesta->Existe){
        session_start();
        $_SESSION["perfil"] = $objRespuesta->Usuario["perfil"];
    }
    echo json_encode($objRespuesta);
}
?>