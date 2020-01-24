<?php
    session_start();
    require_once('db.php');

    $idUsuario = $_SESSION['id']??null;
    $nome_pessoa =  $_POST['nome_pessoa']??null;

    $nome_pessoa = filter_var($nome_pessoa, FILTER_SANITIZE_SPECIAL_CHARS);
    $nome_pessoa = filter_var($nome_pessoa, FILTER_SANITIZE_STRING);

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

    $sql = "SELECT u.id, us.seguindo_id_usuario, u.usuario, u.email ";  
    $sql .= " FROM usuarios AS u"; 
    $sql .= " LEFT JOIN usuarios_seguidores AS us"; 
    $sql .= " ON (us.id_usuario = $idUsuario";
    $sql .= " AND u.id = us.seguindo_id_usuario)";
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
          echo '<p class="list-group-item-text pull-right">';
          
            $esta_seguindo_usuario_sn = isset($registro['seguindo_id_usuario']) 
            && !empty($registro['seguindo_id_usuario'])
            ?'S':'N';

            $btn_seguir_display = 'block';
            $btn_deixar_seguir_display = 'block';

            if($esta_seguindo_usuario_sn == 'S'){
                $btn_seguir_display = "none";
            } else{
                $btn_deixar_seguir_display = "none";
            }

            echo '<button type="button" style="display:'.$btn_seguir_display.'" id="btn_seguir_'.$registro['id'].'" 
            class="btn btn-default btn_seguir" data-id_usuario="'.$registro['id'].'">Seguir</button>';
            echo '<button type="button" style="display:'.$btn_deixar_seguir_display.'" id="btn_deixar_seguir_'.$registro['id'].'" 
            class="btn btn-primary btn_deixar_seguir" data-id_usuario="'.$registro['id'].'">Deixar de Seguir</button>';
          
            echo '</p>';
          echo '<div class="clearfix"></div>';
        echo '</a>';
    
    }while($registro =  mysqli_fetch_assoc($resp));