<?php
require_once(__DIR__ . "/IParte2.php");
require_once(__DIR__ . "/IParte3.php");

class Ovni implements IParte2, IParte3{
    public $tipo;
    public $velocidad;
    public $planetaOrigen;
    public $pathFoto;

    public function __construct($nuevoTipo = "",$nuevaVelocidad = 0, $nuevoOrigen = "" , $nuevoPath = "")
    {
        $this->tipo = $nuevoTipo;
        $this->velocidad = $nuevaVelocidad;
        $this->planetaOrigen = $nuevoOrigen;
        $this->pathFoto = $nuevoPath;
    }

    public function ToJson(){
        return json_encode($this);
    }

    public function Agregar(){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
        
            $consulta = $objetoPDO->prepare("INSERT INTO ovnis(tipo, velocidad, planeta, foto)" .
            "VALUES (:tipo,:velocidad,:planetaOrigen,:pathFoto)");
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_INT);
            $consulta->bindValue(':planetaOrigen', $this->planetaOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function Traer(){
        $objetoPDO;
        $OvnisArray = array();
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
        } catch(PDOException $error){
            return $error;
        }
        $consulta = $objetoPDO->prepare("SELECT tipo,velocidad, planeta AS planetaOrigen, foto AS pathFoto FROM ovnis");
        $consulta->execute();
        $OvnisArray = $consulta->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Ovni");
        return $OvnisArray;
    }
    
    public function ActivarVelocidadWarp(){
        return $this->velocidad * 10.45;
    }

    public function Existe(){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("SELECT * FROM ovnis WHERE tipo = :tipo AND velocidad = :velocidad AND planeta = :planetaOrigen AND foto = :pathFoto");
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_INT);
            $consulta->bindValue(':planetaOrigen', $this->planetaOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetch();
            $retorno = !(empty($resultado));
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public function Modificar($idABuscar){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");
            
            $consulta = $objetoPDO->prepare("UPDATE ovnis SET tipo = :tipo, velocidad = :velocidad, planeta = :planetaOrigen, foto = :pathFoto WHERE id = :id");
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_INT);
            $consulta->bindValue(':planetaOrigen', $this->planetaOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
            $consulta->bindValue(':id', $idABuscar, PDO::PARAM_INT);
            $consulta->execute();
            $count = $consulta->rowCount();
            if($count != '0'){
                $retorno = true;
            }
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public function Eliminar(){
        $retorno = false;
        if($this->Existe()){
            try{
                $objetoPDO = new PDO("mysql:host=localhost;dbname=aliens_bd;charset=utf8", "root", "");                      
                $consulta = $objetoPDO->prepare("DELETE FROM ovnis WHERE tipo = :tipo AND velocidad = :velocidad AND planeta = :planetaOrigen AND foto = :pathFoto");
                $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_INT);
                $consulta->bindValue(':planetaOrigen', $this->planetaOrigen, PDO::PARAM_STR);
                $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
                $consulta->execute();
                $count = $consulta->rowCount();
                if($count != '0'){
                    $retorno = true;
                }
                $objetoPDO = null;
            } catch(PDOException $error){
                return false;
            }
        }
        return $retorno;
    }

    public function GuardarEnArchivo($id){
        $retorno = false;
        $destino = "./archivos";
        $stringEscritura = "";
        if(file_exists($destino)){
            $pathBorrada = $id . "." . $this->tipo . ".borrado." . date("His") . ".jpg";
            if(rename($this->pathFoto, "./ovnisBorrados/" . $pathBorrada)){
                $destino .= "/ovnis_borrados.txt";
                $archivo = fopen($destino, "a");
                $stringEscritura .= "Tipo: " . $this->tipo . " - Velocidad: " . $this->velocidad . " - Planeta: " .
                $this->planetaOrigen . " - PathFoto : ./ovnisBorrados/" . $pathBorrada;
                $stringEscritura .= "\r\n";
                $cantidad = fwrite($archivo, $stringEscritura);
                if($cantidad > 0){
                    $retorno = true;
                }
                fclose($archivo);
            }else{
                echo("Error rename");
            }
        }
        return $retorno;
    }

    public static function MostrarBorrados(){
        $destino = "./archivos/ovnis_borrados.txt";
        $retorno = "no hay ovnis borrados";  
        if(file_exists($destino)){
            $archivo = fopen($destino, "r");
            $retorno = fread($archivo, filesize($destino));
        }
        return $retorno;
    }
}
?>