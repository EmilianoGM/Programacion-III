<?php
/*
------------PHP----------

*******forEach*******

$vec = array(1,2,3);
foreach($vec as $valor)
{
    //$valor es un elemento de la colección	
}

$vec = array(“uno” => 1, “dos” => 2, “tres” => 3);
foreach($vec as $k => $valor)
{
    //$k posee la clave y $valor el elemento	
}

*******arrays*******

$vec = array(1,2,3);
$vec = array("Juan"=>22,"Romina"=>12,"Uriel"=>8); //Asociativo

$vec[0] = 1; $vec[1] = 2; $vec[2] = 3;
$vec["Hugo"]=15; $vec["Juana"]= 36;

*******funciones*******

function NombreFuncion($par_1, $par_2 = "valor"){ 
    //código
}

*******Clases*******

//Constructor
public function __construct() { // código }

//Métodos. 
private function Func1($param) { //código }
protected function Func2() { //código }
public function Func3() { //código }
public static function Func4() { //código }

//Abstractas
abstract class ClaseAbstracta {
		public abstract function Metodo();
}
class ClaseDerivada extends ClaseAbstracta {
		public function Metodo(){
			 //Implementación aquí
		}
}
*******Interfaces*******

interface IInterfaz{
		function Metodo();
}
class Clase implements IInterfaz {
		public function Metodo(){
			//Implementación aquí
		}
}

*******Objetos*******

$nombreObj = new NombreClase();
$nombreObj->Func3();    //De instancia
NombreClase::Func4();   //Estatico  

*******Abrir y escribir archivos*******

$ar = fopen(archivo, modo); devuelve un entero

fclose($ar);

fread(indicador_archivo, filesize(archivo)); devuelve string

while(!feof($ar))
{
	echo fgets($ar), “<br/>”;
}

fwrite(indicador_archivo, texto [,longitud]); Retorna la cantidad de bytes que se escribieron 
												o FALSE si hubo error.
fputs(indicador_archivo, texto [,longitud]);

unlink(archivo); eliminar, devulve true o false

*******Descarga de archivos recibidos*******

$_FILES //Es un array asociativo de elementos cargados al script actual a través del método POST.
[name] => nombre del archivo (con su extensión).
[type] => tipo del archivo (dado por el navegador).
[tmp_name] => carpeta temporal dónde se guardará el archivo subido.
[error] => código de error (si es 0, no hubo errores).
[size] => tamaño del archivo, medido en bytes.

$destino = "uploads/".$_FILES["archivo"]["name"];
move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);

*******Variables de sesion*******
-La información no es almacenada en el cliente.
-HTTP no mantiene estado entre páginas, la utilización de variables de sesión permite mantener 
información acerca de un solo usuario, y están disponibles para todas las páginas del sitio Web

session_start();
$_SESSION[“CLAVE”] = “VALOR”;

session_unset(); //remueve todas las variables de sesión	    

session_destroy(); //destruye la sesión

*******Cookies*******   
-Pequeño archivo que el servidor guarda en el cliente. 

setcookie() //define una cookie para ser enviada junto con el resto de las cabeceras de HTTP. 

*******PHP DATA OBJECT*******
try {
	$conStr = 'mysql:host = localhost; dbname = pruebaDB';	$pdo = new PDO($conStr, $user, $pass);
}
catch(PDOException $e){
	echo ''Error: '' .$e->getMessage() . ''<br/> '';
}

$sentencia = $pdo->prepare('SELECT * FROM tabla');

$sentencia = $pdo->prepare('SELECT * FROM tabla WHERE ID = :id');
$sentencia->bindParam(':id',  $var, PDO::PARAM_INT);

$sentencia->execute();
*/