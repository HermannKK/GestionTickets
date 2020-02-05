<?php
    header("Content-Type:application/json");
    if(isset($_GET["operation"])){
        $operation=$_GET["operation"];
        switch ($operation) {
            case "login":
                echo "i est une pomme";
                break;
            case "get":
                echo "i est une barre";
                break;
            case "reply":
                echo "i est un gateau";
                break;
            case "":
                echo "i est un gateau";
                break;
        }
    }
?>