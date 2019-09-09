<?php
	require_once('clases/producto.php');
?>
<html>
<head>
	<title>Ejemplo de ALTA-LISTADO - con archivos -</title>

	<meta charset="UTF-8">
	<link href="./img/utnLogo.png" rel="icon" type="image/png" />
		
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="estilo.css">

</head>
<body>
	<a class="btn btn-info" href="index.html">Menu principal</a>

	<div class="container">
		<div class="page-header">
			<h1>Ejemplos de Grilla</h1>      
		</div>
		<div class="CajaInicio animated bounceInRight">
			<h1>Listado de PRODUCTOS</h1>

<?php 

$ArrayDeProductos = Producto::TraerTodosLosProductos();
echo "<div>";
foreach ($ArrayDeProductos as $prod){

	echo "
			<p>".$prod->GetCodBarra()."</p>
			<p>".$prod->GetNombre()."</p>
			<img src='". $prod->GetPathFoto()."'>
			<hr>
			
		";
}
echo "</div>";
/*
echo "<table class='table'>
		<thead>
			<tr>
				<th>  COD. BARRA </th>
				<th>  NOMBRE     </th>
			</tr> 
		</thead>";   	

	foreach ($ArrayDeProductos as $prod){

		echo " 	<tr>
					<td>".$prod->GetCodBarra()."</td>
					<td>".$prod->GetNombre()."</td>
				</tr>";
	}	
echo "</table>";
*/	
?>
		</div>
	</div>
</body>
</html>