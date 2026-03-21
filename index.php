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

    if($_POST["REQUEST_METHOD"] == "POST") {
        
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $idade = $_POST["idade"];

        echo "<h2>Dados do formulário</h2>";
        echo "Seja bem-vindo, " . $nome . "<br>";
        echo "Seu email é: " . $email . "<br>";
        echo "Sua idade é: " . $idade . "<br>";

        echo "br>";
        echo "br>";

        echo "<h2>Verificação do tipo de dados</h2>";
        echo "Nome: .gettype($nome) ";
        echo "<br>";
        echo "Email: .gettype($email) . "<br>";
        echo "Idade: .gettype($idade) . "<br>";

        echo "<br>";
        echo "<br>";

        echo "<h3>Verificação de Tipo de Dados</h3>";
        echo $idade = intval($idade);
        echo "Tipo Atual - Via função direta: " . gettype($idade);
        echo  "<br>";
        $idade = (int) $idade;
        echo "Tipo Atual - Via Casting: " . gettype($idade);
        } else {
            echo "O num3 não é um inteiro";
        } 
    }
        
    
?>