<?php
require_once("./clases/Ovni.php");

$objRetorno = new stdClass();
$objRetorno->Exito = false;
$objRetorno->Mensaje = "Fallo Post";

$id = isset($_GET["id"]) ? $_GET["id"] : null;
$idPost = isset($_POST["id"]) ? $_POST["id"] : null;
var_dump(isset($_GET));
var_dump($id);
var_dump($idPost);

if($id != null || $idPost != null){
    try{
        $objetoPDO = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");       
        $consulta = $objetoPDO->prepare("SELECT tipo,velocidad, planeta AS planetaOrigen, foto AS pathFoto FROM ovnis WHERE id = :id");
        if($id != null){
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        } else {
            $consulta->bindValue(':id', $idPost, PDO::PARAM_INT);
        }
        $consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Ovni');
        $ovni = $consulta->fetch();
        var_dump($ovni);
        $resultado = !(empty($ovni));
        if($resultado){
            if($id != null){
                $objRetorno->Exito = true;
                $objRetorno->Mensaje = "El ovni esta en la base de datos";
            } else if(isset($_POST) && isset($_POST["accion"]) && $_POST["accion"] == "borrar"){
                if($ovni->Eliminar()){
                    $ovni->GuardarEnArchivo($idPost);
                    header('Location: ./Listado.php');
                } else{
                    $objRetorno->Mensaje = "Fallo al eliminar";
                }
            }
        } else if (isset($_GET)){
            $objRetorno->Mensaje = "El ovni NO esta en la base de datos";
        }
        $objetoPDO = null;
    } catch(PDOException $error){
        $objRetorno->Mensaje = "error objeto PDO";
    }
}

echo json_encode($objRetorno);

?>
