<?php
session_start();
//remueve todas las variables de sesión	    
session_unset();


//destruye la sesión
session_destroy();
?>