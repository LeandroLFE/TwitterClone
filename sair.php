<?php

    session_start();

    unset($_SESSION['usuario']);
    unset($_SESSION['email']);

    echo 'Até breve...';
    header('refresh:1; url=index.php');

