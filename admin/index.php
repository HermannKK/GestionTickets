<?php
    // if(!isset($_SESSION["role"])){
    //     header("location:../");
    // }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Gestion de tickets</title>
</head>

<body>
    <noscript>Sorry, your browser does not support JavaScript!</noscript>
    <?php include_once('../php/components/navbar.php')?>
    <div class="container-fluid conteneur">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="enTete mx-auto texteCentre">Tickets fermés</div>
                <div class="progress" id="loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                </div>
                <div id="closedTickets"></div>
            </div>
            <div class="col-md-4 mx-auto">
                <div class="enTete mx-auto texteCentre">Mes prises en charges</div>
                <div class="progress" id="loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                </div>
                <div id="myTickets"></div>
            </div>
            <div class="col-md-4">
                <div class="enTete mx-auto texteCentre">Tickets ouverts</div>
                <div class="progress" id="loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                </div>
                <div id="openedTickets"></div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap/jquery-3.4.1.slim.min.js"></script>
    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <script src="../js/bootstrap/popper.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <script>
        $( document ).ready(function() {
            getTickets("admin")
            setInterval(getTickets, 300000,"admin");
        });
    </script>
</body>

</html>