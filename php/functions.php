<?php
    session_start();
    include 'config.php';
    function emailExist($unsafeEmail){
        global $db;
        $email=$db->quote($unsafeEmail);
        $sql = "SELECT id, login, mdp, nom, role FROM users WHERE login=$email";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetch();
        if(!isset($result)){
            var_dump($result);
            return false;
        }
        else{
            echo $unsafeEmail;
            echo $email;
            var_dump($result);
            return true;
        }
    }

    function login($unsafeEmail,$unsafePassword){
        global $db;
        $email=$db->quote($unsafeEmail);
        $password=$db->quote($unsafePassword);
        if(emailExist($email)){
            $sql = "SELECT id, login, mdp, nom, role FROM users WHERE login=$email";
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            if(password_verify($password,$result["mdp"])){
                $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
                $_SESSION["id"]=$result["id"];
                $_SESSION["login"]=$result["login"];
                $_SESSION["nom"]=$result["nom"];
                $_SESSION["role"]=$result["role"];
            }
            else{
                $data = ['error' => ['code'=>002,'message'=>'Mot de passe incorrect'], 'success' => false];
            }
        }
        else{
            $data = ['error' => ['code'=>001,'message'=>'Adresse email inconnue'], 'success' => false];
        }
        return json_encode( $data );
    }

    function submitTicket($unsafeEmail,$unsafeMessage){
        global $db;
        $email=$db->quote($unsafeEmail);
        $message=$db->quote($unsafeMessage);
        $sql = "";
        $query = $db->prepare($sql);
        if($query->execute()){

        }
        else{

        }
    }

    function addUser($unsafeEmail,$unsafePassword,$unsafeName,$unsafeRole){
        global $db;
        $email=$db->quote($unsafeEmail);
        $name=$db->quote($unsafeName);
        $unHasedPassword=$db->quote($unsafePassword);
        $Password=password_hash($unHasedPassword, PASSWORD_DEFAULT);
        $role=$db->quote($unsafeRole);
        $sql = "";
        $query = $db->prepare($sql);
        if($query->execute()){

        }
        else{

        }
    }

    function cancelTicket(){
        global $db;
        $sql="";
        $query = $db->prepare($sql);
        if($query->execute()){

        }
        else{

        }
    }

    function takeTicket(){
        global $db;
        $sql="";
        $query = $db->prepare($sql);
        if($query->execute()){

        }
        else{
            
        }
    }

    function ReplyTicket($idTicket, $idGestionnaire ){
        global $db;
        $sql="";
        $query = $db->prepare($sql);
        if($query->execute()){

        }
        else{
            
        }
    }

    function getTickets($role){
        global $db;
        if($role=="admin"){
            $sql = "SELECT idTicket, idClient,idGestionnaire,etat,message,reponse,dateCreation,datePriseEnCharge,dateFermeture FROM tickets";
        }
        if($role=="client"){
            $id=$db->quote($_SESSION['id']);
            $sql = "SELECT idTicket, idClient,idGestionnaire,etat,message,reponse,dateCreation,datePriseEnCharge,dateFermeture FROM tickets WHERE idClient=$id ORDER BY dateCreation DESC";
        }
        $query = $db->prepare($sql);
        if($query->execute()){
            $data = $query->fetchAll();
        }
        else{
            $data = ['error' => ['code'=>003,'message'=>'requete non executée'], 'success' => false];
        }
        return json_encode( $data );
    }
    //exemple d'ijnjections sql
    emailExist('"" or ""=""');
    emailExist("105 OR 1=1");
    emailExist("105; DROP TABLE users")
?>