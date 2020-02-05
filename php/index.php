<?php
    if(!isset($_SESSION["role"]) && $_SESSION["role"] != "dev"){
        header("location:../");
    }
?>