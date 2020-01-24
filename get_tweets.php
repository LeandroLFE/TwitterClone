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

    $sql = "SELECT t.id_tweet, t.id_usuario, DATE_FORMAT(t.data_inclusao, '%d-%b-%Y às %T') AS data_inclusao, t.tweet, u.usuario";  
    $sql .= " FROM tweet AS t"; 
    $sql .= " INNER JOIN usuarios as u";
    $sql .= " ON (t.id_usuario = u.id)";
    $sql .= " WHERE t.id_usuario = $idUsuario";
    $sql .= " OR t.id_usuario IN ";
        $sql .= " (SELECT seguindo_id_usuario";
        $sql .= " FROM usuarios_seguidores"; 
        $sql .= " WHERE id_usuario = $idUsuario)";
    $sql .= " ORDER BY t.data_inclusao DESC";

    $resp = mysqli_query($link, $sql);

    if(!$resp){
        exit("Falha na consulta ao Banco de Dados");
    }

    while($registro =  mysqli_fetch_assoc($resp)){
        echo "<a href='#' class='list-group-item'>";
            echo "<h4 class='list-group-item-heading'>{$registro['usuario']} <small> - {$registro['data_inclusao']} ";

            $pode_excluir_tweet = $registro['id_usuario']==$idUsuario?'block':'none';

            echo "<img src='imagens/lixeira.png'
                class='exclui_tweet pull-right' 
                style='display: $pode_excluir_tweet'
                id='tweet_".$registro['id_tweet']."' 
                data-tweet='{$registro['id_tweet']}' 
                alt='Excluir tweet'>";
            echo "</small></h4>";
            echo '<div class="clearfix"></div>';
            echo "<p class='list-group-item-text'>{$registro['tweet']}</p>";
            
        echo '</a>';
    }