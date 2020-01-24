<?php
session_start();
require_once('db.php');

$id_tweet = $_POST['id_tweet_a_excluir']??null;
$idUsuario = $_SESSION['id']??null;

if(empty($id_tweet) || empty($idUsuario)){
    header('Location: index.php?erro=1');
    exit("Dados inválidos");
}

$obJDb = new db();
$link = $obJDb->conecta_mysql();

$sql =  "DELETE FROM tweet";
$sql .= " WHERE id_tweet = $id_tweet";

if(!mysqli_query($link, $sql)){
    exit("Falha na exclusão de dados");
}