<?php
    session_start();
    require_once('db.php');

    $idUsuario = $_SESSION['id']??null;

    if(empty($idUsuario)){
        header('Location: index.php?erro=1');
        exit("Dados inválidos");
    }

    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    $sql = "SELECT DATE_FORMAT(t.data_inclusao, '%d-%b-%Y às %T') AS data_inclusao, t.tweet, u.usuario";  
    $sql .= " FROM tweet AS t"; 
    $sql .= " INNER JOIN usuarios as u";
    $sql .= " ON (t.id_usuario = u.id)";
    $sql .= " WHERE t.id_usuario = $idUsuario ORDER BY t.data_inclusao DESC";

    $resp = mysqli_query($link, $sql);

    if(!$resp){
        exit("Falha na consulta ao Banco de Dados");
    }

    while($registro =  mysqli_fetch_assoc($resp)){
        echo "<a href='#' class='list-group-item'>";
            echo "<h4 class='list-group-item-heading'>{$registro['usuario']} <small> - {$registro['data_inclusao']} </small></h4>";
            echo "<p class='list-group-item-text'>{$registro['tweet']}</p>";
        echo '</a>';
    }
