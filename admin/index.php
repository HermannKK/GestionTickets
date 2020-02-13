<?php
session_start();
if (!isset($_SESSION["role"])) {
    header("location:../");
}
if (isset($_SESSION["role"]) && $_SESSION["role"] == "client") {
    header("location:../public/");
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
    <div id="addUser" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajout d'utilisateur</h4>
                </div>
                <div class="modal-body">
                    <div id="errorFieldModal"></div>
                    <form onsubmit="addUser()" id="addUserForm">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nameBox" placeholder="Nom" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="emailBox" placeholder="Adresse email" required>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" type="password" value="" id="passwordBox" placeholder="Mot de passe" required autocomplete="current-password">
                                <div class="input-group-append">
                                    <div class="input-group-text" onClick="showPassword()" id="eyeIcon" title="Afficher le mot de passe"><i class="fa fa-eye pointerOnHover"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Droits</label>
                            <select class="form-control" id="roleBox">
                                <option value="admin">Gestionnaire</option>
                                <option value="client">Client</option>
                            </select>
                        </div>
                        <div id="addUserError" class="" role="alert" ></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-default positive" id="addUserButton" onclick="addUser()">Soummettre</button>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid conteneur">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="enTete mx-auto texteCentre">Tickets fermés</div>
                <div class="progress loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                </div>
                <div id="closedTickets" class="ticketList"></div>
            </div>
            <div class="col-md-4 mx-auto">
                <div class="enTete mx-auto texteCentre">Mes prises en charges</div>
                <div class="progress loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                </div>
                <div id="myTickets" class="ticketList"></div>
            </div>
            <div class="col-md-4">
                <div class="enTete mx-auto texteCentre">Tickets ouverts</div>
                <div class="progress loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div>
                </div>
                <div id="openTickets" class="ticketList"></div>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap/jquery-3.4.1.slim.min.js"></script>
    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <script src="../js/bootstrap/popper.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <script>
        $(document).ready(function() {
            setInterval(getTickets, 300, "admin");
            $('[data-toggle="popover"]').popover();
        });
    </script>
</body>

</html>