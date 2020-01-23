<?php
    session_start();
    require_once('db.php');

    $idUsuario = $_SESSION['id']??null;
    $nome_pessoa =  $_POST['nome_pessoa']??null;

    if(empty($idUsuario)){
        header('Location: index.php?erro=1');
        exit("Dados inválidos");
    }

    if(empty($nome_pessoa)){
        header('Location: home.php');
        exit("Nome procurado inválido");
    }
    
    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    $sql = "SELECT u.usuario, u.email ";  
    $sql .= " FROM usuarios AS u"; 
    $sql .= " WHERE u.usuario like '%$nome_pessoa%'";
    $sql .= " AND u.id <> $idUsuario ";

    $resp = mysqli_query($link, $sql);

    if(!$resp){
        exit("Falha na consulta ao Banco de Dados");
    }
    $registro =  mysqli_fetch_assoc($resp);

    do{
        echo "<a href='#' class='list-group-item'>";
          echo "<strong>{$registro['usuario']}</strong> <small> - {$registro['email']} </small>";
        echo '</a>';
    }while($registro =  mysqli_fetch_assoc($resp));