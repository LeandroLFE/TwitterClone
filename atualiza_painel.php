<?php
session_start();

if(empty($_SESSION['usuario']) || empty($_SESSION['id'])){
    header('Location: index.php?erro=1');
}

$idUsuario = $_SESSION['id']??null;

$usuario = $_SESSION['usuario']??null;

require_once('db.php');

$obJDb = new db();
$link = $obJDb->conecta_mysql();

// qtde de tweets
$sql = "SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $idUsuario";

$qtde_tweets = 0;

$resp = mysqli_query($link, $sql);

if($resp){
    $respAssoc = mysqli_fetch_assoc($resp);
    $qtde_tweets = $respAssoc['qtde_tweets'];
} else{
    exit('Erro ao executar a query');
}

// qtde de seguidores
$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $idUsuario";

$qtde_seguidores = 0;

$resp = mysqli_query($link, $sql);
if($resp){
    $respAssoc = mysqli_fetch_assoc($resp);
    $qtde_seguidores = $respAssoc['qtde_seguidores'];
} else{
    exit('Erro ao executar a query');
}

echo <<<SAIDA
    <h4 style="text-align:center">$usuario</h4>
    <hr>
    <div class="col-md-5">
    TWEETS <br> $qtde_tweets
    </div>
    <div class="col-md-7">
    SEGUIDORES <br> $qtde_seguidores
    </div>
SAIDA;
