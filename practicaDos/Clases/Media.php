<?php
require_once './CLASES/Usuario.php';

class Media
{
    public $id;
    public $color;
    public $marca;
    public $precio;
    public $talle;

    public function __construct($id = null, $color = "", $marca = "", $precio = 0, $talle = "sin talle")
    {
        $this->id = $id;
        $this->color = $color;
        $this->marca = $marca;
        $this->precio = $precio;
        $this->talle = $talle;
    }

    public function AgregarDB(){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        
            $consulta = $objetoPDO->prepare("INSERT INTO medias(color, marca, precio, talle)" .
            "VALUES (:color,:marca,:precio,:talle)");
            $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function TraerDB(){
        $objetoPDO;
        $medias = array();
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        } catch(PDOException $error){
            return $error;
        }
        $consulta = $objetoPDO->prepare("SELECT * FROM medias");
        //$consulta->setFetchMode(PDO::FETCH_INTO, new Televisor);
        $consulta->execute();
        $medias = $consulta->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Media");
        return $medias;
    }

    public static function ExisteDB($idABuscar){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("SELECT * FROM medias WHERE id = :id");
            $consulta->bindValue(':id', $idABuscar, PDO::PARAM_INT);
            $consulta->execute();
            $resultado = $consulta->fetch();
            $retorno = !(empty($resultado));
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function EliminarDB($idABuscar){
        $retorno = false;
        if(Media::ExisteDB($idABuscar)){
            try{
                $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");                      
                $consulta = $objetoPDO->prepare("DELETE FROM medias WHERE id = :id");
                $consulta->bindValue(':id', $idABuscar, PDO::PARAM_INT);
                $consulta->execute();
                $count = $consulta->rowCount();
                if($count != '0'){
                    $retorno = true;
                }
                $objetoPDO = null;
            } catch(PDOException $error){
                var_dump($error);
                return false;
            }
        }
        return $retorno;
    }

    public function ModificarDB($idABuscar){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("UPDATE medias SET color = :color, marca = :marca, precio = :precio, talle = :talle WHERE id = :id");
            $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':talle', $this->talle, PDO::PARAM_STR);
            $consulta->bindValue(':id', $idABuscar, PDO::PARAM_INT);
            $consulta->execute();
            $count = $consulta->rowCount();
            if($count > 0){
                $retorno = true;
            }
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function AltaMedia($request, $response, $args)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo al agregar";
        
        $datos = $request->getParsedBody();
        $datosJSON = json_decode($datos['media']);
        $media = new Media(null,$datosJSON->color, $datosJSON->marca, $datosJSON->precio, $datosJSON->talle);
        
        if($media->AgregarDB()){
            $objRetorno->Exito = true;
            $objRetorno->Mensaje = "Agregado";
        }

        return $response->withJson($objRetorno, 200); 
    }

    public static function ListadoMedias($request, $response, $args){
        $objRetorno = new stdClass();
        $objRetorno->Exito = true;
        $objRetorno->Mensaje = "Listado";
        $objRetorno->Datos = Media::TraerDB();
        //CAMBIAR A SOLO LISTADO JSON
        return $response->withJson($objRetorno, 200); 
    }

    public static function EliminarMedia($request, $response, $args)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo al eliminar";
        
        $datos = $request->getParsedBody();
        $id_media = (int)$datos['id_media'];
        if(Media::ExisteDB($id_media)){
            if(Media::EliminarDB($id_media)){
                $objRetorno->Exito = true;
                $objRetorno->Mensaje = "Media eliminada";
            }
        } else{
            $objRetorno->Mensaje = "Id no encontrado";
        }
        return $response->withJson($objRetorno, 200); 
    }

    public static function ModificarMedia($request, $response, $args)
    {
        $objRetorno = new stdClass();
        $objRetorno->Exito = false;
        $objRetorno->Mensaje = "Fallo al modificar";
        
        $datos = $request->getParsedBody();
        $datosJSON = json_decode($datos['media']);
        $id_media = $datosJSON->id;
        if(Media::ExisteDB($id_media)){
            $media = new Media(null,$datosJSON->color, $datosJSON->marca, $datosJSON->precio, $datosJSON->talle);
            if($media->ModificarDB($id_media)){
                $objRetorno->Exito = true;
                $objRetorno->Mensaje = "Modificado";
            }
        } else{
            $objRetorno->Mensaje = "Media no encontrada";
        }

        return $response->withJson($objRetorno, 200); 
    }

}

?>