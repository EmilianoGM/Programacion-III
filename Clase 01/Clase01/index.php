<?php
    $nombre = "emiLiano";
    $apellido = "mEdina";

    $firstchar = $nombre[0];
    $firstchar = strtoupper($firstchar);
    
    $firstcharApellido = $apellido[0];
    $firstcharApellido = strtoupper($firstcharApellido);
    
    $resto  = strtolower(substr($nombre, 1, strlen($nombre) - 1));
    $restoDos = strtolower(substr($apellido, 1, strlen($apellido) - 1));
    
    $nombre = $firstchar . $resto;
    $apellido = $firstcharApellido . $restoDos;
    
    echo $nombre. " ".$apellido; 