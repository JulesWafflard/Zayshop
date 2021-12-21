<?php
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=zayshop', 'root', '');
    } catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}



?>