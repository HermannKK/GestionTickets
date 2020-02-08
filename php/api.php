<?php
    include_once("functions.php");
    header("Content-Type:application/json");
    if(isset($_POST["operation"])){
        $operation=$_POST["operation"];
        switch ($operation) {
            case "login":
                echo(login($_POST['email'],$_POST['password']));
                break;
            case "getTickets":
                echo(getTickets());
                break;
            case "replyTicket":
                echo(ReplyTicket($_POST['idTicket'],$_POST['message']));
                break;
            case "submitTicket":
                echo(submitTicket($_POST['message']));
                break;
            case "addUser":
                echo(addUser($_POST['email'],$_POST['password'],$_POST['name'],$_POST['role']));
                break;
            case "cancelTicket":
                echo(cancelTicket($_POST['idTicket']));
                break;
            case "takeTicket":
                echo(takeTicket($_POST['idTicket']));
                break;
            case "disconnect":
                echo(disconnect());
                break;
            default :
                $data = ['error' => ['code'=>005,'message'=>'Operation non reconnue'], 'success' => false];
                echo json_encode($data);
                break;
        }
    }
?>