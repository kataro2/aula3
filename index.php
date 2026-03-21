<?php

    echo "<h2>Exemplo verificação is_int</h2>";

    $num1 = 3.5;
    $num2 = "kennedy";


    echo "Valor do numero 1:" . $num1;
    echo "<br>";
    echo "Valor do numero 2:" . $num2;
    echo "<br>";
    
    if (is_float($num1)) {
        echo "O num1 -e um float";
    } else {
        echo "O num1 não é um float";
    }  

    echo "<br>";

    if (is_string($num2)) {
        echo "O num2 é uma string";
    } else {
        echo "O num2 não é uma string";
    }   
        
    
?>