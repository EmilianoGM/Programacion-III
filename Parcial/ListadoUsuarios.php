<?php
require_once("./clases/Usuario.php");
if(isset($_GET)){
    $destino = "./archivos/usuarios.json";  
    if(file_exists($destino)){
        $archivo = fopen($destino, "r");
        $stringUsuarios = fread($archivo, filesize($destino));
        var_dump($stringUsuarios);
    }  
}
?>