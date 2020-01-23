<?php
    require_once('db.php');
    session_start();

    $texto_tweet = $_POST['texto_tweet']??null;
    $idUsuario = $_SESSION['id']??null;

    if(empty($texto_tweet) || empty($idUsuario)){
        header('Location: index.php?erro=1');
        exit("Dados inválidos");
    }

    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    $sql = "INSERT INTO tweet(id_usuario, tweet) VALUES($idUsuario , '$texto_tweet')";

    if(!mysqli_query($link, $sql)){
        exit("Deu ruim");
    }