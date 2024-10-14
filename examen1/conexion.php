<?php

function get_sql_client()
{
   $host = '***';
   $user = '***';
   $passwd = '***';
   $dbname = '***';

   $conn = new mysqli($host, $user, $passwd, $dbname);
   if ($conn->connect_error)
      die("Conection Error: $conn->connect_error");

   return $conn;
}