<?php
    $servername = "remotemysql.com:3306";
    $username = "jGzYDmjsBr";
    $password = "Iv9XGmPd6p";
    $dbname = "jGzYDmjsBr";
    $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, //Protection contre injection SQL, ca force le serveur a ne pas envoyer de requettes modifiées directement depuis le code
        ];
    try {
        
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
?>
