<?php
    $servername = "remotemysql.com:3306";
    $username = "jGzYDmjsBr";
    $password = "Iv9XGmPd6p";
    $dbname = "jGzYDmjsBr";
    // Creation de la connexion
    $db = mysqli_connect($servername, $username, $password, $dbname);
    // Verification de la connexion
    if (!$db) {
        die();
    }
?>