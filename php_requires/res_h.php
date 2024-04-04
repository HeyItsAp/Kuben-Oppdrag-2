<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and validate data
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $passord = validate($_POST['passord']);

    echo $username . '<br>';
    echo $passord . '<br>';

    if(empty($username) || empty($passord)) {
        header( "refresh:0; url=../registration.php" );
        echo '<script> alert("Something is missing");</script>';
        die("");
    }
    
    try {
        require_once "dbh_kunde.php";
        $query = "INSERT INTO bruker (brukernavn, passord) values (:brukernavn, :passord);";
        $stmt = $pdo -> prepare($query);
        $stmt -> bindParam(':brukernavn', $username);
        $stmt -> bindParam(':passord', $passord);
        $stmt -> execute();

        // Closing the connection
        $pdo = null;
        $stmt = null;        
        header( "refresh:0; url=../index.php" );
        echo '<script> alert("Sign up sucsess");</script>';
        die("");
            
        } catch (PDOException $e) {
            die("Failed " . $e->getMessage()); // die(); terminater scriptet og printer ut inni ()
        }
        
} else {
    header("Location: ../index.php"); // Sender personen tilbake til index.php hvis det er ingen php
}