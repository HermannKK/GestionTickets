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

<body onload="getTickets()">
    <noscript>Sorry, your browser does not support JavaScript!</noscript>
    <?php include_once('../php/components/navbar.php') ?>
    <div class="container-fluid conteneur">
        <div class="row">
            <div class="gauche col-md-4">
                <div class="enTete mx-auto texteCentre">Mes tickets</div>
                <div class="antiScroll">
                    <div class="date">22-01-2020</div>
                    <!-- card -->
                    <div class="card col" id="00001">
                        <div class="row">
                            <div class="col-6 nom">FOMO Doriane</div>
                            <div class="col-6 heure">15:09</div>
                        </div>
                        <div class="row text-wrap text-break p">
                            <span class="description ">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer id elit finibus, viverra nunc eu, auctor arcu. Suspendisse tempus finibus metus, ut pretium nisl auctor ac
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-5 disconnect">Annuler</div>
                            <div class="col-5 texteEtat">En cours de traitement</div>
                            <div class="col-2">
                                <div class="etat traitement"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin card -->
                    <div class="date">21-01-2020</div>
                    <div class="card" id="00002">
                        <div class="row">
                            <div class="col-6 nom">FOMO Doriane</div>
                            <div class="col-6 heure">15:09</div>
                        </div>
                        <div class="row text-wrap text-break p">
                            <span class="description ">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer id elit finibus, viverra nunc eu, auctor arcu. Suspendisse tempus finibus metus, ut pretium nisl auctor ac
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-7 disconnect">Annuler</div>
                            <div class="col-4 texteEtat">En cours de traitement</div>
                            <div class="col-1">
                                <div class="etat traitement"></div>
                            </div>
                        </div>
                    </div>
                    <div class="date">20-01-2020</div>
                    <div class="card" id="00003">
                        <div class="row">
                            <div class="col-6 nom">FOMO Doriane</div>
                            <div class="col-6 heure">15:09</div>
                        </div>
                        <div class="row text-wrap text-break p">
                            <span class="description ">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer id elit finibus, viverra nunc eu, auctor arcu. Suspendisse tempus finibus metus, ut pretium nisl auctor ac
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-7 disconnect">Annuler</div>
                            <div class="col-4 texteEtat">En cours de traitement</div>
                            <div class="col-1">
                                <div class="etat traitement"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="00003">
                        <div class="row">
                            <div class="col-6 nom">FOMO Doriane</div>
                            <div class="col-6 heure">15:09</div>
                        </div>
                        <div class="row text-wrap text-break p">
                            <span class="description ">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer id elit finibus, viverra nunc eu, auctor arcu. Suspendisse tempus finibus metus, ut pretium nisl auctor ac
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-7 disconnect">Annuler</div>
                            <div class="col-4 texteEtat">termine</div>
                            <div class="col-1">
                                <div class="etat termine"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="00003">
                        <div class="row">
                            <div class="col-6 nom">FOMO Doriane</div>
                            <div class="col-6 heure">15:09</div>
                        </div>
                        <div class="row text-wrap text-break p">
                            <span class="description ">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer id elit finibus, viverra nunc eu, auctor arcu. Suspendisse tempus finibus metus, ut pretium nisl auctor ac
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-7 disconnect">Annuler</div>
                            <div class="col-4 texteEtat">ouvert</div>
                            <div class="col-1">
                                <div class="etat ouvert"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="00003">
                        <div class="row">
                            <div class="col-6 nom">FOMO Doriane</div>
                            <div class="col-6 heure">15:09</div>
                        </div>
                        <div class="row text-wrap text-break p">
                            <span class="description ">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer id elit finibus, viverra nunc eu, auctor arcu. Suspendisse tempus finibus metus, ut pretium nisl auctor ac
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-7 disconnect">Annuler</div>
                            <div class="col-4 texteEtat">En cours de traitement</div>
                            <div class="col-1">
                                <div class="etat traitement"></div>
                            </div>
                        </div>
                    </div>
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
                        <div class="col-8 ultraLigth" id="caracteresRestants">2000 caractères restants</div>
                        <div class="col-2 resetButton disconnect btn btn-link" onclick="resetForm()">Reinitialiser</div>
                        <div class="col-2 submitButton positive btn btn-link" onclick="submitTicket()">Envoyer</div>
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
        setInterval(getTickets, 3000);
    </script>
</body>

</html>