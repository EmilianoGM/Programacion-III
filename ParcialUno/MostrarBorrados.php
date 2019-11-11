<?php
require_once("./clases/Ovni.php");
if(isset($_GET)){
    echo Ovni::MostrarBorrados();
    }else{
    echo "fallo GET";
}
?>