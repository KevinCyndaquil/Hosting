<?php
    $host = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $passwd = $_ENV['DB_PSWD'];

    $conn = new mysqli($host, $user, $passwd, $passwd);
    if ($conn->connect_error) 
        die("Conection Error: $conn->connect_error");