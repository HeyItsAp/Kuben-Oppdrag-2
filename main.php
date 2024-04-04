<?php
session_start();
if (!isset($_SESSION["login"]) && $_SESSION["login"] != true) {
    header("refresh:0; url=index.php");
    echo '<script> alert("You need to be logged in to acsess this");</script>';
}
$text_color = 'text-primary';
if ($_SESSION['clearance'] == 1){
    $text_color = 'text-success';
} else if ($_SESSION['clearance'] == 2){
    $text_color = 'text-danger';
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
    <section class="container my-5">
        <div class="row d-flex justify-content-center g-4">
            <!-- Universell card hendvisning -->
            <div class="col-8 col-lg-6 col-xl-4">
                <div class="card shadow">
                    <img src="FjellBilde.jpg" class="card-img-top" alt="Fjell bilde" />
                    <div class="card-body">
                        <h4> Send inn problemet</h4>
                        <p class="card-text">
                            Send inn en ticket til kontoret vårt slik at du kan få den løst!
                        </p>
                        <div>
                            <a href="problem.php" type="button" class="btn btn-link ps-0 text-decoration-none">Send her
                                <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kunde: Se hendvisninger -->
            <div class="col-8 col-lg-6 col-xl-8">
                <div class="row gap-2">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <h4> Konto management</h4>
                                <p class="card-text">
                                    Velkommen,
                                    <?php print '<span class="' . $text_color . '">' . $_SESSION['brukernavn'] .'</span>'; ?>
                                </p>
                                <div>
                                    <a href="php_requires/logout_h.php" type="button"
                                        class="btn btn-link ps-0 text-decoration-none"><i class="bi bi-lock-fill"></i>
                                        Logg ut </a>
                                        <a href="userSettings.php" type="button" class="btn btn-link ps-0 text-decoration-none text-primary"><i class="bi bi-person-fill"></i> Endre brukernavn og passord </a>

                                    <?php
                                        if ($_SESSION['clearance'] == 2){
                                            print '<a href="adminManage.php" type="button" class="btn btn-link ps-0 text-decoration-none ' . $text_color . '"><i class="bi bi-clipboard2-minus"></i> Kontroller brukere </a>';
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <h4> See statusen på problemer</h4>
                                <p class="card-text">
                                    Her kan du se om problemene dine et løst eller ikke
                                <div>
                                    <!-- Status? -->
                                </div>
                                </p>
                                <div>
                                    <?php 
                                        print '<a href="problemHandler.php" type="button" class="btn btn-link ps-0 text-decoration-none ' . $text_color . '">See her <i class="bi bi-arrow-right"></i></a>';
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card py-5"
                            style="background-image: url('FjellBilde.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">

                        </div>
                    </div>

                </div>
            </div>
        </div>
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