<?php
require_once("./clases/Ufologo.php");
if(isset($_GET)){
    $destino = "./archivos/ufologos.json";  
    if(file_exists($destino)){
        $archivo = fopen($destino, "r");
        $stringUfologos = fread($archivo, filesize($destino));
        echo $stringUfologos;
    }  
}else{
    echo "fallo GET";
}
?>