<?php
session_start();
if(!(isset($_SESSION["perfil"]))){
    header("./login.php");
}
?>
<html>
<head>
	<title>LOGIN</title>
	  
		<meta charset="UTF-8">
        <script src="manejador7.js"></script>
</head>
<body>
			<h1>GENERADOR PDF</h1>      				
				<button>Click Me!</button>
                <?php
                if(isset($_SESSION["perfil"]) && $_SESSION["perfil"] == 1){
                ?>
                    <button onclick="window.location.href='./test_pdf.php'">Usuario</button>
                <?php
                }
                ?>
                <button>Log out</button>
                
</body>
</html>