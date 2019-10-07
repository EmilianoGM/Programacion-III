<?php
require_once(__DIR__ . "/IParte2.php");
class Televisor implements IParte2{
    public $tipo;
    public $precio;
    public $paisOrigen;
    public $path;

    public function __construct($nuevoTipo = "", $nuevoPrecio = 0, $nuevoPaisOrigen = "", $nuevoPath = "")
    {
        $this->tipo = $nuevoTipo;
        $this->precio = $nuevoPrecio;
        $this->paisOrigen = $nuevoPaisOrigen;
        $this->path = $nuevoPath;
    }

    public function ToJson(){
        return json_encode($this);
    }

    public function Agregar(){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        
            $consulta = $objetoPDO->prepare("INSERT INTO televisores(tipo, precio, paisOrigen, path)" .
            "VALUES (:tipo,:precio,:paisOrigen,:path)");
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':paisOrigen', $this->paisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':path', $this->path, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public static function Traer(){
        $objetoPDO;
        $televisores = array();
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        } catch(PDOException $error){
            return $error;
        }
        $consulta = $objetoPDO->prepare("SELECT * FROM televisores");
        //$consulta->setFetchMode(PDO::FETCH_INTO, new Televisor);
        $consulta->execute();
        $televisores = $consulta->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Televisor");
        return $televisores;
    }

    public function Modificar($nuevoTipo, $nuevoPrecio = 0, $nuevoPaisOrigen = "", $nuevoPath = ""){
        $retorno = false;
        try{
            $objetoPDO = new PDO("mysql:host=localhost;dbname=prueba;charset=utf8", "root", "");
        
            $consulta = $objetoPDO->prepare("UPDATE televisores SET precio = :precio," .
            "paisOrigen=:paisOrigen,path=:path WHERE tipo =:tipo");
            $consulta->bindValue(':tipo', $nuevoTipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $nuevoPrecio, PDO::PARAM_INT);
            $consulta->bindValue(':paisOrigen', $nuevoPaisOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':path', $nuevoPath, PDO::PARAM_STR);
            $retorno = $consulta->execute();
            /*if($retorno->rowCount() > 0){
                $retorno = true; 
            }*/
            $objetoPDO = null;
        } catch(PDOException $error){
            return false;
        }
        return $retorno;
    }

    public function CalcularIVA(){
        return $this->precio + ($this->precio * 0.21);
    }
}

?>