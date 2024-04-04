<?php
session_start();
function fancyDump($array)
{
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
}

if (!isset($_SESSION["login"]) && $_SESSION["login"] != true) {
    header("refresh:0; url=login.php");
    echo '<script> alert("You need to be logged in to acsess this");</script>';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
    if ($_SESSION['clearance'] != 0){
        try {
            require_once 'php_requires/dbh_kunde.php';
            $query = "SELECT * FROM problem";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $problemER = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOExecption $e) {
            die("Failed : " . $e->getMessage()); 
        }

        $Nofound = false;
        if (count($problemER) == 0) {
            $Nofound = true;
        }
    } else {
        try {
            require_once 'php_requires/dbh_kunde.php';
            $query = "SELECT * FROM problem WHERE forfatter_id = :forfatter_id";        
            $stmt = $pdo->prepare($query);
            $stmt -> bindParam(':forfatter_id', $_SESSION['id']);
            $stmt->execute();
            $problemER = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOExecption $e) {
            die("Failed : " . $e->getMessage()); 
        }

        // fancyDump($problemER);
        $Nofound = false;
        if (count($problemER) == 0) {
            $Nofound = true;
        }
    }
    ?>
    <section class="container my-5">
        <div class="row w-100 d-flex justify-content-center mb-2">     
            <div class="col-lg-7 col-12">
                <div class="card py-5" style="background-image: url('FjellBilde.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;"><div class="card-body text-center"><h3 class="bg-white border rounded border-dark py-2 px-4">Problemene</h3></div></div>
            </div>
        </div>
        <div class="row w-100 d-flex justify-content-center">     
            <div class="col-5 col-lg-2">
                <div class="card">  
                    <div class="card-body d-flex justify-content-center">
                        <a href="main.php">Hoved menyen <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container d-flex justify-content-center">   
        <?php
        if ($Nofound) {
            print '<div class="card"><div class="card-body">Ingen problemer</div></div>';
        } else {
            foreach ($problemER as $ENproblem) {
                print '<div class="card m-2">';
                print '<div class="card-header">';
                print '<h3>' . $ENproblem['problem_title'] . "</h3>";
                print '</div>';
                print '<div class="card-body">';

                try {
                    $query = "SELECT * FROM bruker WHERE id_bruker = :id_bruker";
                    $stmt = $pdo->prepare($query);
                    $stmt -> bindParam(':id_bruker', $ENproblem['forfatter_id']);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOExecption $e) {
                    die("Failed : " . $e->getMessage()); 
                }
        

                if ($result){
                    $forfatter = $result['brukernavn'];
                } else {
                    $forfatter = "en tidligere bruker";

                }

      
                print '<p class="fst-italic"> Skrevet av, ' . $forfatter . '</p>'; 
                
                
                if ($ENproblem['problem_status'] == 0) {
                    print '<div class="mb-2 text-danger d-flex align-items-center"><i class="bi bi-x fs-4"></i><h4> Sendt </h4></div>';
                } else {
                    print '<div class="mb-2 text-succses d-flex align-items-center"><i class="bi bi-check-lg fs-4 me-1"></i><h4> Fiks er tilgjengelig </h4></div>';

                }
                print '<p>' . $ENproblem['problem_text'] . '</p>';


                print '</div>';
                print '<div class="card-footer">';
                print '<form method="post" action="problemHandlerHandler.php">';
                print '<input type="hidden" name="problem_id" value="' . $ENproblem['id_problem'] . '" />';
                if ($ENproblem['problem_status'] == 1) {
                    print '<input type="submit" name="seeFiks" class="btn btn-primary m-1" value="See Fks her" />';
                }
                if ($_SESSION['clearance'] == 1) {
                    print '<input type="submit" name="fiksProblem" class="btn btn-success m-1" value="Oppdater problem" />';
                }
                if ($_SESSION['clearance'] == 2) {
                    print '<input type="submit" name="fiksProblem" class="btn btn-success m-1" value="Oppdater her" />';
                    print '<input type="submit" name="slettProblem" class="btn btn-danger m-1" value="Slett" />';
                }
                print '</form>';
                print '</div>';
                print '</div>';
            }
        }

        ?>
    </section>



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