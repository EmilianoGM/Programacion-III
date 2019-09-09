<?php
class Archivo{
    public static function Subir(){
        $flag = FALSE;

        if ($_FILES["imagen"]["size"] > 800000) {
            echo "El archivo es demasiado grande";
            $flag = FALSE;
        } else {
            $destino = "Archivos/" . $_FILES["imagen"]["name"];
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
            echo "guardado";
            $flag = TRUE;
        }
        return $flag;
    }
}
?>