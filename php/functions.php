<?php
    include_once 'config.php';
    session_start();

    function getActualHour(){
        date_default_timezone_set("Europe/Paris");
        return date("YmdHi");
    }

    function unquote(string $quoted){
        return stripslashes(substr($quoted, 1, -1));
    }

    function emailExist($unsafeEmail){
        global $db;
        $email=$db->quote($unsafeEmail);
        $sql = "SELECT id, login, mdp, nom, role FROM users WHERE login=$email";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetch();
        if(!isset($result['login'])){
            return false;
        }
        else{
            return true;
        }
    }

    function login($unsafeEmail,$unsafePassword){
        global $db;
        $email=$db->quote($unsafeEmail);
        $password=$db->quote($unsafePassword);
        if(emailExist($unsafeEmail)){
            $sql = "SELECT id, login, mdp, nom, role FROM users WHERE login=$email";
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            if(password_verify($password,$result["mdp"])){
                $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true, 'role' =>$result["role"]];
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

    function submitTicket($unsafeMessage){
        global $db;
        $unsafeDate=getActualHour();
        $date=$db->quote($unsafeDate);
        $id=$db->quote($_SESSION['id']);
        $message=$db->quote($unsafeMessage);
        $sql = "INSERT INTO tickets (idClient, message, dateCreation) VALUES ($id, $message ,$date)";
        $query = $db->prepare($sql);
        if($query->execute()){
            $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
        }
        else{
            $data = ['error' => ['code'=>003,'message'=>'requete non executée'], 'success' => false];
        }
        return json_encode( $data );
    }

    function addUser($unsafeEmail,$unsafePassword,$unsafeName,$unsafeRole){
        global $db;
        if(!emailExist($unsafeEmail) && $_SESSION['role']=='admin'){
            $email=$db->quote($unsafeEmail);
            $name=$db->quote($unsafeName);
            $unhasedPassword=$db->quote($unsafePassword);
            $hasedPassword=password_hash($unhasedPassword, PASSWORD_DEFAULT);
            $role=$db->quote($unsafeRole);
            $sql = "INSERT INTO users (login, mdp, nom ,role) VALUES (:email, :hasedPassword ,:name, :role)";
            $query = $db->prepare($sql);
            if($query->execute(['email'=>unquote($email),'hasedPassword'=>$hasedPassword ,"name"=>unquote($name),"role"=>unquote($role)])){
                $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
            }
            else{
                $data = ['error' => ['code'=>003,'message'=>'requete non executée'], 'success' => false];
            }
        }else{
            $data = ['error' => ['code'=>004,'message'=>'Cette adresse email est deja enregistrée'], 'success' => false];
        }
        return json_encode( $data );
    }

    function cancelTicket($unsafeIdTicket){
        global $db;
        $idTicket=$db->quote($unsafeIdTicket);
        $etat=$db->quote("Annulé");
        $unsafeDate=getActualHour();
        $date=$db->quote($unsafeDate);
        $sql="UPDATE tickets SET etat=$etat, dateFermeture=$date WHERE idTicket = $idTicket";
        $query = $db->prepare($sql);
        if($query->execute()){
            $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
        }
        else{
            $data = ['error' => ['code'=>003,'message'=>'requete non executée'], 'success' => false];
        }
        return json_encode( $data );
    }

    function takeTicket($unsafeIdTicket){
        global $db;
        if($_SESSION['role']=="admin"){
            $idTicket=$db->quote($unsafeIdTicket);
            $idGestionnaire=$db->quote($_SESSION['id']);
            $unsafeDate=getActualHour();
            $date=$db->quote($unsafeDate);
            $etat=$db->quote("traitement");
            $sql="UPDATE tickets SET idGestionnaire = $idGestionnaire, etat=$etat, datePriseEnCharge=$date WHERE idTicket = $idTicket";
            $query = $db->prepare($sql);
            if($query->execute()){
                $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
            }
            else{
                $data = ['error' => ['code'=>003,'message'=>'requete non executée'], 'success' => false];
            }
        }
        else{
            $data = ['error' => ['code'=>006,'message'=>"Autorisations insufisante"], 'success' =>false];
        }
        return json_encode( $data );
    }

    function ReplyTicket($unsafeIdTicket, $unsafeMessage ){
        global $db;
        if($_SESSION['role']=="admin"){
            $idTicket=$db->quote($unsafeIdTicket);
            $idGestionnaire=$db->quote($_SESSION['id']);
            $message=$db->quote($unsafeMessage);
            $unsafeDate=getActualHour();
            $date=$db->quote($unsafeDate);
            $etat=$db->quote("fermé");
            $sql="UPDATE tickets SET idGestionnaire = $idGestionnaire,reponse= $message, etat=$etat, dateFermeture=$date WHERE idTicket = $idTicket";
            $query = $db->prepare($sql);
            if($query->execute()){
                $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
            }
            else{
                $data = ['error' => ['code'=>003,'message'=>'requete non executée'], 'success' => false];
            }
        }
        else{
            $data = ['error' => ['code'=>006,'message'=>"Autorisations insufisante"], 'success' =>false];
        }
        return json_encode( $data );
    }

    function getTickets(){
        global $db;
        if($_SESSION['role']=="admin"){
            $sql = "SELECT idTicket, idClient,idGestionnaire,etat,message,reponse,dateCreation,datePriseEnCharge,dateFermeture FROM tickets";
        }
        if($_SESSION['role']=="client"){
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

    function disconnect(){
        if(session_destroy()){
            $data = ['error' => ['code'=>NULL,'message'=>NULL], 'success' => true];
        }
        else{
            $data = ['error' => ['code'=>007,'message'=>'Impossible de vous deconnecter'], 'success' => false];
        }
        var_dump($data);
        return json_encode( $data );
    }
    
    //Tests
    //exemple d'ijnjections sql
    // emailExist('"" or ""=""');
    // emailExist("105 OR 1=1");
    // emailExist("105; DROP TABLE users");
    // addUser("admin@test.com","test","admin test","admin");
    //emailExist("admin@st.com");
    //login("admin@test.com","test");
    //getTickets();
    //submitTicket("Hello je suis un test");
    //takeTicket(3);
    //ReplyTicket(3,"hello je suis une reponse");
    //disconnect();
?>