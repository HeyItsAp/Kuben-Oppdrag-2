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
require_once "php_requires/dbh_admin.php";

if (!isset($_SESSION["login"]) && $_SESSION["clearance"] != 2) {
    header("refresh:0; url=login.php");
    echo '<script> alert("You need to admin");</script>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete_bruker"])){
        try {
            echo '<script> alert("Deleting ... ");</script>';
            $id_bruker = validate($_POST['id_bruker']);

            $query = "DELETE FROM bruker WHERE id_bruker = :id_bruker;";
            $stmt = $pdo -> prepare($query);
            $stmt -> bindParam(':id_bruker', $id_bruker);
            $stmt -> execute();


            if ($id_bruker == $_SESSION['id']){

                session_unset();
                session_destroy();
                
                header( "refresh:0; url=../index.php" );
                echo '<script> alert("You deleted yourself :D ");</script>';
            }


        } catch (PDOExecption $e){              
            echo "Connection Error: " . $e->getMessage();
        }
    } else if (isset($_POST['oppdater_clearance'])){
        try {
            echo '<script> alert("Submiting new values ... ");</script>';

            $clearance = validate($_POST['new_clearance']);
            $id_bruker = validate($_POST['id_bruker']);


            $query = "UPDATE bruker SET clearance = :clearance WHERE id_bruker = :id_bruker";
            $stmt = $pdo -> prepare($query);
            $stmt -> bindParam(':clearance', $clearance);
            $stmt -> bindParam(':id_bruker', $id_bruker);
            $stmt -> execute();

            if ($id_bruker == $_SESSION['id']){
                $_SESSION['clearance'] = $clearance;
            }


            echo '<script> alert("Submiting WORKED DWHADHAHWD");</script>';
            } catch (PDOExecption $e){
                echo "Connection Error: " . $e->getMessage();
            }
            
        }
}
require_once "php_requires/dbh_admin.php"; 
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
        <!-- Table 1 -->
        <?php
                $query = "SELECT id_bruker, brukernavn, clearance FROM bruker";
                $stmt = $pdo -> prepare($query);
                $stmt -> execute();
                $brukERE = $stmt ->fetchAll(PDO::FETCH_ASSOC);

                // fancyDump($result);
                $Nofound = false;
                if (count($brukERE) == 0){
                    $Nofound = true;
                }
        ?>
        <div class="container my-5">
            <h2 class="text-center display-4 m-2"> Admin panel </h2>
            <p class="text-center m-2"> Du kan bare endre admin rettigheter til andre </p>
            <a href="main.php" class="btn btn-link text-center m-2 text-decoration-none w-100">Hovedmenyen <i class="bi bi-arrow-right"></i></a>

            <?php
                if ($Nofound){
                    echo '<h3 class="text-center"> Ingen personer </h2>';
                }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php
                            if (!$Nofound){
                                foreach ($brukERE[0] as $key => $row){
                                    print '<th scope="col">' . $key . '</th>';
                                }
                                print '<th scope="col"> Buttons </th>';

                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php    
                        if (!$Nofound){
                            $forbruker = 'text-primary';
                            $ansatt = 'text-success';
                            $admin = 'text-danger';

                            foreach ($brukERE as $key => $row){
                                $id_bruker = $row['id_bruker'];
                                $brukernavn = $row['brukernavn'];
                                $clearance = $row['clearance'];
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $id_bruker ?></th>
                                    <th scope="row"><?php echo $brukernavn ?></th>
                                    <td>
                                        <form method="post">
                                            <select name="new_clearance" class="form-select">
                                                <option value="0" class="text-primary" <?php echo $clearance == "0" ? "selected" : "" ?>> Forbruker </option>
                                                <option value="1" class="text-success" <?php echo $clearance == "1" ? "selected" : "" ?>> Ansatt </option>
                                                <option value="2" class="text-danger" <?php echo $clearance == "2" ? "selected" : "" ?>> Admin </option>
                                            </select>
                                    </td>
                                    <td>
                                            <?php print '<input type="hidden" name="id_bruker" value="'. $id_bruker. '">'; ?>
                                            <button type="submit" name="delete_bruker" class="btn btn-danger mx-1"> Delete </button>
                                            <button type="submit" name="oppdater_clearance" class="btn btn-success mx-1"> Oppdaterer clearance </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
<body>
 


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