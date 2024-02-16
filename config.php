<?php

$servername = "mysql:host=localhost;dbname=customer_information";
$username = "root";
$password = "";


$pdo = new PDO( $servername , $username, $password );
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 