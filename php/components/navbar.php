<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Jessica EBA'A</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
            if(isset($_SESSION["role"]) && $_SESSION["role"]=="admin"){
                echo('
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#closedTickets">Tickets fermés</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#myTickets">Mes prises en charge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#OpenTickets">Tickets ouverts</a>
                        </li>
                    </ul>
                    <a class="nav-link disconnect" href="#">Deconnexion</a>
                </div>
            ');
            }
            else{
                echo('
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#myTickets">Mes tickets</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#SubmitTickets">Soumettre un nouveau ticket</a>
                        </li>
                    </ul>
                    <a class="nav-link disconnect" href="#">Deconnexion</a>
                </div>
            ');
            }
         ?>
        
    </nav>
    <script type="text/javascript" src="../js/script.js"></script>
    <script src="../../js/bootstrap/jquery-3.4.1.slim.min.js"></script>
    <script src="../../js/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/bootstrap/popper.min.js"></script>
</body>

</html>