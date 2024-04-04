<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and validate data
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $brukernavn = validate($_POST['brukernavn']);
    $passord = validate($_POST['passord']);
    // echo $username . '<br>';
    // echo $pwd . '<br>';
    if(empty($brukernavn) || empty($passord)) {
        header( "refresh:0; url=../index.php" );
        echo '<script> alert("Something is missing");</script>';
        die("");
    }

    try {
        require_once "dbh_kunde.php"; 
        $query = "SELECT * FROM bruker WHERE brukernavn = :brukernavn";
        $stmt = $pdo -> prepare($query);
        $stmt -> bindParam(':brukernavn', $brukernavn);
        $stmt -> execute();
        $result = $stmt ->fetch(PDO::FETCH_ASSOC);
        if ($result && $passord == $result['passord']) {
            // Found Login
            $_SESSION['login'] = true;
            $_SESSION['brukernavn'] = $brukernavn;
            $_SESSION['passord'] = $passord;
            $_SESSION['id'] = $result['id_bruker'];
            $_SESSION['clearance'] = $result['clearance'];


            $pdo = null;
            $stmt = null; 
            header( "refresh:0; url=../main.php" );
            echo '<script> alert("Logged in, ass '.$_SESSION['brukernavn'] . '"); </script>';


        } else {
            // Cant find Login
            $pdo = null;
            $stmt = null;           
            header( "refresh:0; url=../index.php" );
            echo '<script> alert("Log in fail");</script>';
            die("");

        }
    } catch (PDOExecption $e) {
        die("Failed : " . $e->getMessage()); 
    }
} else {
    header("Location: ../login.php");
}
