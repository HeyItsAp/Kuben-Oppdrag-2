<?php
session_start();
function fancyDump($array){
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
}
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!isset($_SESSION["login"]) && $_SESSION["login"] != true) {
    header("refresh:0; url=login.php");
    echo '<script> alert("You need to be logged in to acsess this");</script>';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["seeFiks"]) || isset($_POST["fiksProblem"])){
        require_once 'php_requires/dbh_kunde.php';
        $query = "SELECT * FROM problem WHERE id_problem = :id_problem";
        $stmt = $pdo->prepare($query);
        $stmt -> bindParam(':id_problem', $_POST['problem_id']);
        $stmt->execute();
        $problemET = $stmt->fetch(PDO::FETCH_ASSOC);
        // fancyDump($problemET);
    
    } if (isset($_POST['submitFiks'])){
        $fiks_text = validate($_POST['fiks_text']);
        $problem_id = validate($_POST['problem_id']);

        $checked = 1;
        try {
            require_once "php_requires/dbh_admin.php"; 
            $query = "UPDATE problem SET problem_status = :problem_status, fiks_text = :fiks_text, fiks_dato = :fiks_dato WHERE id_problem = :id_problem";
            $stmt = $pdo -> prepare($query);
            $stmt -> bindParam(':problem_status', $checked);
            $stmt -> bindParam(':fiks_text', $fiks_text);
            $stmt -> bindParam(':fiks_dato', date('y-m-d'));
            $stmt -> bindParam(':id_problem', $problem_id);
    
            $stmt -> execute();
    
            header( "refresh:0; url=main.php" );
            echo '<script> alert("Fiks is sendt");</script>';
        } catch (PDOExecption $e) {
            die("Failed : " . $e->getMessage()); 
        }
        try {

        } catch (PDOExecption $e) {
            die("Failed : " . $e->getMessage()); 
        }
      
      
    }
} else {
    header("Location: problemHandler.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fjell Bedriftsløsninger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    if (isset($_POST['seeFiks'])){
        print '<section class="container my-5">';
            print '<div class="row d-flex justify-content-center">';
                print '<div class="col-9">';
                    print '<div class="card shadow">';
                        print '<div class="card-header">';
                            print '<h3>' . $problemET['problem_title'] . '</h3>';                            
                        print '</div>';
                        print '<div class="card-body">';

                            $query = "SELECT * FROM bruker WHERE id_bruker = :id_bruker";
                            $stmt = $pdo->prepare($query);
                            $stmt -> bindParam(':id_bruker', $problemET['forfatter_id']);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
                            if ($result){
                                $forfatter = $result['brukernavn'];
                            } else {
                                $forfatter = "en tidligere bruker";
            
                            }  

                            try {
                                $query = "SELECT kategori FROM kategori WHERE id_kategori = :id_kategori";
                                $stmt = $pdo->prepare($query);
                                $stmt -> bindParam(':id_kategori', $problemET['kategori_id_kategori']);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            } catch (PDOExecption $e) {
                                die("Failed : " . $e->getMessage()); 
                            }
                            if ($result){
                                $kategori = $result['kategori'];
                            } else {
                                $kategori = "en tidligere kategori";
            
                            }

                            
                            print '<p class="fs-6">' . $problemET['problem_text'] . ' || skrevet av ' . $forfatter . ' || kategori: ' . $kategori . '</p>';
                            print '<p class="fst-italic mt-3 mb-0">' . $problemET['fiks_text'] . '</p>'; 
                            
                        print '</div>';
                        print '<div class="card-footer d-flex justify-content-between">';
                            print '<p class="fst-italic">Sist oppdatert: ' . $problemET['fiks_dato'] . '</p>';
                            print '<a href="problemHandler.php" class="btn btn-link">  Gå tilbake </a>';
                        print '</div>';
                    print '</div>';
                print'</div>';
            print'</div>';
        print '</section>';


    } else if (isset($_POST['fiksProblem'])){
        print '<section class="container mt-5">';
            print '<div class="row d-flex justify-content-center">';
                print '<div class="col-9">';
                    print '<div class="card shadow">';
                        print '<div class="card-body">';
                            print '<h2>Send fiks</h2>';
                            print '<div class="card">';
                                print '<div class="card-body fst-italic">' . $problemET['problem_title'] . ': ' . $problemET['problem_text'] . '</div>';
                            print' </div>';
                            print '<div class="mb-3">';
                                print '<form method="post" action="">';
                                print '<input type="hidden" name="problem_id" value="' . $problemET['id_problem'] . '" />';
                                print '<label for="fiks_text" class="form-label">Fiks detaljer:</label>';
                                print '<textarea class="form-control" name="fiks_text" rows="3" value="' . $problemET['fiks_text'] . '"></textarea>';
                            print '</div>';
                        print' </div>';
                        print '<div class="card-footer d-flex justify-content-between">';
                            print '<input class="btn btn-primary btn-block" type="submit" name="submitFiks" value="Send fiks">';
                            print '<a href="main.php" class="btn btn-link"> Tilbake </a>';
                            print '</form>';
                        print '</div>';
                    print '</div>';
                print '</div>';
            print '</div>';
        print '</section>';


    } else if (isset($_POST['slettProblem'])){
        $problem_id = validate($_POST['problem_id']);
        try {
            require_once "php_requires/dbh_admin.php"; 
            $query = "DELETE FROM problem WHERE id_problem = :id_problem";
            $stmt = $pdo -> prepare($query);
            $stmt -> bindParam(':id_problem', $problem_id);
            $stmt -> execute();
    
            header( "refresh:0; url=main.php" );
            echo '<script> alert("Deleted");</script>';
            die("");
        } catch (PDOExecption $e) {
            die("Failed : " . $e->getMessage()); 
        }

    }




  

   
    ?>

 



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>