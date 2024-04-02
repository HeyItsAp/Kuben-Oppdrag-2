<?php
$dsn = "mysql:host=localhost;dbname=oppdrag2";
$dbusername = "adminUser";
$dbpassword = "admin123";
try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOExecption $e){
    echo "Connection Error: " . $e->getMessage(); 
}