<?php

    session_start();
    require_once('db.php');

    $idUsuario = $_SESSION['id']??null;
    $seguirIdUsuario = $_POST['seguir_id_usuario']??null;

    if(empty($idUsuario) || empty($seguirIdUsuario) || ($idUsuario == $seguirIdUsuario) ){
        die("Dados inválidos");
    }

    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    $sql = "INSERT INTO usuarios_seguidores(id_usuario, seguindo_id_usuario) VALUES($idUsuario , $seguirIdUsuario)";

    if(!mysqli_query($link, $sql)){
        exit("Falha na inclusão de dados");
    }


