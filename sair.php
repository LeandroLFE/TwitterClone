<?php

    session_start();

    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);

    echo 'Até breve...';
    header('refresh:1; url=index.php');

