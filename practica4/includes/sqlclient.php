<?php
    $conn = new mysqli("localhost", "kevincyndaquil", "qw6xdg7sB!", "progwebmov");
    if ($conn->connect_error) 
        die("Conection Error: $conn->connect_error");