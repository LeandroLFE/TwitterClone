<?php

    require('db.php');

    $usuario = $_POST['usuario']??null;

    $email = $_POST['email']??null;

    $senha = $_POST['senha']?password_hash($_POST['senha'],PASSWORD_BCRYPT):null;

    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    if(empty($usuario) || empty($email)){
        exit("Dados invalidos recebidos");
    }

    $sql = "Insert into usuarios(usuario, email, senha) VALUES('$usuario', '$email', '$senha')";

    //executar a query
    $resultado = mysqli_query($link, $sql)?"Usuario registrado com sucesso":"Erro no registro dos campos!";

    echo $resultado;