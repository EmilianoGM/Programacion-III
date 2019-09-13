<html>
<head>
	<title>LOGIN</title>
	  
		<meta charset="UTF-8">

		<link href="./img/utnLogo.png" rel="icon" type="image/png" />

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	<a class="btn btn-info" href="index.html">Menu principal</a>
<?php     
	require_once("clases\producto.php");
?>
	<div class="container">
	
		<div class="page-header">
			<h1>LOGIN</h1>      
		</div>
		<div class="CajaInicio animated bounceInRight">
			<h1>ALTA-LISTADO - con archivos -</h1>

			<form id="FormIngreso" method="post" enctype="multipart/form-data" action="administracion.php" >
				<input type="text" name="usuario" placeholder="Ingrese nombre de usuario"  />
				<input type="text" name="clave" placeholder="Ingrese clave"  />
				<input type="submit" class="MiBotonUTN" name="acceder" placeholder="Acceder"/>
			</form>
		
		</div>
	</div>
</body>
</html>