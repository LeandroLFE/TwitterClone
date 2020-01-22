<?php

    session_start();

    require_once('db.php');

    $usuario = $_POST['usuario']??null;
    $senha = $_POST['senha']??null;

    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resp = mysqli_query($link, $sql);
    $respAssoc = mysqli_fetch_assoc($resp);

    if(!$resp){
        echo "Erro na consulta ao Banco de Dados, favor contactar o administrador do site";
    } else {
        if(isset($respAssoc['usuario'])
        && isset($respAssoc['senha']) 
        && password_verify($senha, $respAssoc['senha'])){

            $_SESSION['usuario'] = $respAssoc['usuario'];
            $_SESSION['senha'] = $respAssoc['senha'];
            header('Location: Home.php');
            
        } else{
            header("Location: index.php?erro=1");
        }  
    } 
