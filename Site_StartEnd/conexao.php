<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "clientes";
    
    try{
       $conn = new PDO("mysql:host=$host;dbname=" .$dbname, $user, $pass);  
    }catch(PDOException $erro){
        $erro->getMessage();
    }

  