<?php
require_once ("clases/producto.php");
require_once ("clases/archivo.php");

$alta = isset($_POST["guardar"]) ? TRUE : FALSE;

//var_dump($_FILES);
if($alta) {

	$flag = Archivo::Subir();
	if($flag){
		$ruta = "Archivos/" . $_FILES["imagen"]["name"];
		$p = new Producto($_POST["codBarra"],$_POST["nombre"],$ruta);
		if(!Producto::Guardar($p)){
			$mensaje = "Lamentablemente ocurrio un error y no se pudo escribir en el archivo.";
			include("mensaje.php");
		}
		else{
			$mensaje = "El archivo fue escrito correctamente. PRODUCTO agregado CORRECTAMENTE!!!";			
		}
	}
	
}//if $alta
?>