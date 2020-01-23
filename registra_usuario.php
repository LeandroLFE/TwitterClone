<?php

    require_once('db.php');

    $usuario = $_POST['usuario']??null;

    $email = $_POST['email']??null;

    $senha = $_POST['senha']?password_hash($_POST['senha'],PASSWORD_BCRYPT):null;

    $obJDb = new db();
    $link = $obJDb->conecta_mysql();

    if(empty($usuario) || empty($email)){
        exit("Dados invalidos recebidos");
    }
    
    $usuario_existe = false;
    $email_existe = false;

    //verificar se o usuário ou o email existem
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";

    if ($resp = mysqli_query($link, $sql)){

        $dados_usuario = mysqli_fetch_assoc($resp);

        do{   
            if(isset($dados_usuario['usuario'])){
                if($usuario == $dados_usuario['usuario']){
                    $usuario_existe = true;
                } 
                if($email == $dados_usuario['email']){
                    $email_existe = true;
                }
            } 
        } while($dados_usuario = mysqli_fetch_assoc($resp));

    } else{
        echo 'Erro ao tentar localizar registro do usuário';
    }

    if($usuario_existe || $email_existe){
        
        $retornoGet = '';

        if($usuario_existe){
            $retornoGet .= "erro_usuario=1&";
        } 
        if ($email_existe){
            $retornoGet .= "erro_email=1&";
        }

        header('Location: inscrevase.php?'.$retornoGet);
        die();
    }

    $sql = "Insert into usuarios(usuario, email, senha) VALUES('$usuario', '$email', '$senha')";

    //executar a query
    $resultado = mysqli_query($link, $sql)?"Usuario registrado com sucesso":"Erro no registro dos campos!";
    echo $resultado;

    header('refresh:1; url=index.php');