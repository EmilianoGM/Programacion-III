<?php

$accion = isset($_POST['accion']) ? $_POST['accion'] : NULL;
$id = isset($_POST['id']) ? $_POST['id'] : NULL;
$codigo_barra = isset($_POST['codigo_barra']) ? $_POST['codigo_barra'] : NULL;
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
$path_foto = isset($_POST['path_foto']) ? $_POST['path_foto'] : NULL;
var_dump($_POST);
$host = "localhost";
$user = "root";
$pass = "";
$base = "mercado";

$connection = @mysqli_connect($host, $user, $pass, $base);

switch($accion){
    case "TraerTodos_productos":
        $sql = "SELECT * FROM productos";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        while ($row = $resultado->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
            $user_arr[] = $row;
        }
        var_dump($user_arr);
    break;
    case "TraerPorId_productos":
        if($id == NULL){
            return;
        }
        $sql = "SELECT * FROM productos WHERE id = $id";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        while ($row = $resultado->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
            $user_arr[] = $row;
        }
        var_dump($user_arr);
    break;
    case "Agregar_productos":
        if($nombre == NULL || $codigo_barra == NULL){
            echo "Faltan parametros";
            return;
        }
        if($path_foto == NULL){
            $sql = "INSERT INTO `producto`(`codigo_barra`, `nombre`) VALUES ('$codigo_barra','$nombre')";
            $resultado = $connection->query($sql);
        } else {
            $sql = "INSERT INTO `producto`(`codigo_barra`, `nombre`, `path_foto`) VALUES ('$codigo_barra','$nombre', '$path_foto')";
            $resultado = $connection->query($sql);
        }
        //var_dump($resultado);
        echo "Filas afectadas: " . mysqli_affected_rows($connection);
    break;
    case "Modificar_productos":
        if($id == NULL || $nombre == NULL || $codigo_barra == NULL){
            echo "Faltan parametros";
            return;
        }
        $sql = "UPDATE `producto` SET `codigo_barra`='$codigo_barra',`nombre`='$nombre',`path_foto`='$path_foto' WHERE id = $id";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        echo "Filas afectadas: " . mysqli_affected_rows($connection);
    break;
    case "Borrar_productos":
        if($id == NULL){
            echo "Faltan parametros";
            return;
        }
        $sql = "DELETE FROM `producto` WHERE id = $id";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        echo "Filas afectadas: " . mysqli_affected_rows($connection);
    break;
    default:
    echo "error";
}

    mysqli_close($connection);
?>