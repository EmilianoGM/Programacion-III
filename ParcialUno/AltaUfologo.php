<?php
require_once("./clases/Ufologo.php");
if(isset($_POST["pais"]) && isset($_POST["legajo"]) && isset($_POST["clave"])){
    $pais = $_POST["pais"];
    $legajo = $_POST["legajo"];
    $clave = $_POST["clave"];
    $nuevoUfologo = new Ufologo($pais, $legajo, $clave);
    $objRetorno = $nuevoUfologo->GuardarEnArchivo();
    echo json_encode($objRetorno);
} else {
    echo "Error en POST";
}
?>