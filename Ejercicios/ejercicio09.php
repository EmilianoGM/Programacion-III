<?php
    $lista = array();

    for ($i=0; $i < 5; $i++) { 
        $lista[$i] = rand(0,10);
    }

    $suma = 0;
    foreach ($lista as $value) {
        $suma += $value;
    }

    $promedio = $suma / count($lista);
    
    echo var_dump($lista) . "<br>";

    if($promedio > 6){
        echo "El promedio es mayor a 6";
    } elseif ($promedio == 6){
        echo "El promedio es 6";
    } else{
        echo "El promedio es menor a 6";
    }