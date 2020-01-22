<?php

    $usuario = $_POST['usuario']??null;

    $email = $_POST['email']??null;

    $senha = $_POST['senha']?password_hash($_POST['senha'],PASSWORD_BCRYPT):null;

    