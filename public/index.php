<?php
    session_start();
    if(!isset($_SESSION["role"])){
        header("location:../");
    }
    if(isset($_SESSION["role"]) && $_SESSION["role"]=="admin"){
        header("location:../admin/");
    }
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
    <?php include_once('../php/components/navbar.php') ?>
    <div class="container-fluid conteneur">
        <div class="row">
            <div class="gauche col-md-4">
                <div class="enTete mx-auto texteCentre">Mes tickets</div>
                <div class="progress" id="loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                </div>
                <div class="antiScroll mx-auto" id="ticketList">
                    <div id="root"></div>
                </div>
            </div>
            <div class="droite col-md-6 col-md-offset-2">
                <div class="enTete">Soummettre un nouveau ticket</div>
                <div class="col card submit">
                    <div class="row enTeteSubmit">Dites nous en quoi nous pouvons vous aider</div>
                    <div class="row conteneurZone">
                        <textarea onkeyup="countLetters()" maxlength="2000" class="zoneDeTexte" id="textBox" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-5 ultraLigth" id="caracteresRestants">2000 caractères restants</div>
                        <div class="col-4 resetButton disconnect btn btn-link" onclick="resetForm()">Reinitialiser</div>
                        <div class="col-3 submitButton positive btn btn-link" onclick="submitTicket()">Envoyer</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap/jquery-3.4.1.slim.min.js"></script>
    <script src="../js/bootstrap/popper.min.js"></script>
    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
    <script>
        $( document ).ready(function() {
            setInterval(getTickets, 300,"client");
            $('[data-toggle="popover"]').popover();
        });
    </script>
</body>

</html>