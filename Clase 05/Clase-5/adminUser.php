<?php
$accion = isset($_POST['accion']) ? $_POST['accion'] : NULL;
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
$id = isset($_POST['id']) ? $_POST['id'] : NULL;
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : NULL;
$clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
$perfil = isset($_POST['perfil']) ? $_POST['perfil'] : NULL;
$estado = isset($_POST['estado']) ? $_POST['estado'] : 0;
//$accion = "TraerTodos_usuarios";
//var_dump($_POST);
$host = "localhost";
$user = "root";
$pass = "";
$base = "mercado";

$connection = @mysqli_connect($host, $user, $pass, $base);

switch($accion){
    case "TraerTodos_usuarios":
        $sql = "SELECT * FROM usuarios";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        while ($row = $resultado->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
            $user_arr[] = $row;
        }
        echo "<table>
                <tr><td>1</td><td>2</td></tr>
        ";
        echo "  <tr><td>3</td><td>4</td></tr>
              <table>
        ";
        //var_dump($user_arr);
    break;
    case "TraerPorId_usuarios":
        if($id == NULL){
            return;
        }
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        while ($row = $resultado->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
            $user_arr[] = $row;
        }
        var_dump($user_arr);
    break;
    case "TraerPorEstado_usuarios":
        $sql = "SELECT * FROM usuarios WHERE estado = $estado";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        while ($row = $resultado->fetch_object()){ //fetch_all / fetch_assoc / fetch_array([MYSQLI_NUM | MYSQLI_ASSOC | MYSQLI_BOTH])
            $user_arr[] = $row;
        }
        var_dump($user_arr);
    break;
    case "Agregar_usuarios":
        if($nombre == NULL || $apellido == NULL || $clave == NULL || $perfil == NULL){
            echo "Faltan parametros";
            return;
        }
        $sql = "INSERT INTO `Usuarios`(`nombre`, `apellido`, `clave`, `perfil`, `estado`) VALUES ('$nombre','$apellido','$clave','$perfil','$estado')";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        echo "Filas afectadas: " . mysqli_affected_rows($connection);
    break;
    case "Modificar_usuarios":
        if($id == NULL || $nombre == NULL || $apellido == NULL || $clave == NULL || $perfil == NULL){
            echo "Faltan parametros";
            return;
        }
        $sql = "UPDATE `Usuarios`SET `nombre`='$nombre',`apellido`='$apellido',`clave`='$clave',`perfil`='$perfil',`estado`= '$estado' WHERE id = $id";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        echo "Filas afectadas: " . mysqli_affected_rows($connection);
    break;
    case "Borrar_usuarios":
        if($id == NULL){
            echo "Faltan parametros";
            return;
        }
        $sql = "DELETE FROM `Usuarios` WHERE `id` = $id";
        $resultado = $connection->query($sql);
        //var_dump($resultado);
        echo "Filas afectadas: " . mysqli_affected_rows($connection);
    break;
    default:
    echo "error";
}

mysqli_close($connection);
?>