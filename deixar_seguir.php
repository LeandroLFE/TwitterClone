<?php

    session_start();
    require_once('db.php');

    $idUsuario = $_SESSION['id']??null;
    $deixarSeguirIdUsuario = $_POST['deixar_seguir_id_usuario']??null;

    if(empty($idUsuario) || empty($deixarSeguirIdUsuario) || ($idUsuario == $deixarSeguirIdUsuario) ){
        die("Dados inválidos");
    }

    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    $sql = "DELETE FROM usuarios_seguidores"; 
    $sql .= " WHERE id_usuario = $idUsuario"; 
    $sql .= " AND seguindo_id_usuario =  $deixarSeguirIdUsuario";

    if(!mysqli_query($link, $sql)){
        exit("Falha na exclusão de dados");
    } 


