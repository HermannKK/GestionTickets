<?php
    require("database.php");
    function emailExist($email){
        $sql = "SELECT id, login, mdp, nom, role FROM users WHERE login=='$email'";
        $result = mysqli_query($db,$sql);
        $count = mysqli_num_rows($result);
        if($count == 0){
            return false;
        }
        else{
            return true;
        }
    }

    function login($email,$password){
        if(emailExist($email)){
            $sql = "SELECT id, login, mdp, nom, role FROM users WHERE login=='$email'";
            $result = mysqli_query($db,$sql);
            $row=mysqli_fetch_assoc ( $result );
            if($password===$row["mdp"]){
                $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
                session_start();
                $_SESSION["id"]=$row["id"];
                $_SESSION["login"]=$row["login"];
                $_SESSION["nom"]=$row["nom"];
                $_SESSION["role"]=$row["role"];
                header('Content-type: application/json');
                echo json_encode( $data );
            }
            else{
                $data = ['error' => ['code'=>002,'message'=>'Mot de passe incorrect'], 'success' => false];
                header('Content-type: application/json');
                echo json_encode( $data );
            }
        }
        else{
            $data = ['error' => ['code'=>001,'message'=>'Adresse email inconnue'], 'success' => false];
            header('Content-type: application/json');
            echo json_encode( $data );
        }

    }

    function submitTicket(){

    }

    function updateTicket(){

    }

    function getTickets(){
        $id=$_SESSION["id"];
        if($_SESSION["role"]=="admin"){
            $sql = "SELECT id, login, mdp, nom, role FROM tickets WHERE login=='$email'";
        }
        if($_SESSION["role"]=="client"){
            $sql = "SELECT idTicket, idClient,idGestionnaire,etat,message,reponse,dateCreation,datePriseEnCharge,dateFermeture FROM tickets WHERE idClient=='$id'";
        }
        header('Content-type: application/json');
        echo json_encode( $data );
    }
?>