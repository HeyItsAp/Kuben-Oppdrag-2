<?php
$dsn = "mysql:host=localhost;dbname=oppdrag2";
$dbusername = "kundeUser";
$dbpassword = "kunde123";
try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOExecption $e){
    echo "Connection Error: " . $e->getMessage(); 
}
// SELECT and INSERT privliges