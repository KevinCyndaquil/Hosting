<?php
    $host = 'sql105.infinityfree.com';
    $user = 'if0_37364684';
    $passwd = 'W1hELAmlGZgZJv5';
    $dbname = 'if0_37364684_progwebmov';

    $xd = "W1hELAmlGZgZJv5";

    $conn = new mysqli($host, $user, $passwd, $dbname);
    if ($conn->connect_error) 
        die("Conection Error: $conn->connect_error");