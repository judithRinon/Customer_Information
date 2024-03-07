<?php
require 'config.php';

$response = array();

try {
    $pdo = new PDO($servername, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        SELECT * FROM customerdata WHERE Patient_ID = :Patient_ID
    ");
    $stmt->bindValue(':Patient_ID', $_POST["Patient_ID"], PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $response = $data;
   
} catch (PDOException $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>