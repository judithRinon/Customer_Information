<?php
require 'config.php';

if(isset($_POST["Contact_Number"])) {
    $contactNumber = $_POST["Contact_Number"];
    $firstName = $_POST["First_Name"];
    $email = $_POST["Email"];

    try {
        $pdo = new PDO($servername, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM customerdata WHERE 
            ContactNumber = :ContactNumber OR 
            FirstName = :FirstName OR 
            Email = :Email"
        );

        $stmt->bindValue(':ContactNumber', $contactNumber, PDO::PARAM_STR);
        $stmt->bindValue(':FirstName', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':Email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $rowCount = $stmt->rowCount();
        if ($rowCount > 1) {
            // Fetch all patient IDs
            $patientIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo json_encode(array("status" => "error", "message" => "Multiple records found", "patientIds" => $patientIds));
            exit;
        } elseif ($rowCount > 0) {
            $patientId = $stmt->fetch(PDO::FETCH_COLUMN);
            echo json_encode(array("status" => "error", "message" => "Duplicate record found", "patientId" => $patientId));
            exit;
        }
    } catch(PDOException $e) {
        echo json_encode(array("status" => "error", "message" => $e->getMessage()));
        exit;
    }
}

try {
    $pdo = new PDO($servername, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        INSERT INTO customerdata 
        (`FirstName`, `MiddleName`, `SurName`, `Birthdate`, `ContactNumber`, `Email`) 
        VALUES 
        (:First_Name, :Middle_Name, :Sur_Name, :Birthdate, :Contact_Number, :Email)
    ");

    $stmt->bindValue(':First_Name', $_POST["First_Name"],  PDO::PARAM_STR);
    $stmt->bindValue(':Middle_Name', $_POST["Middle_Name"], PDO::PARAM_STR);
    $stmt->bindValue(':Sur_Name', $_POST["Sur_Name"], PDO::PARAM_STR);
    $stmt->bindValue(':Birthdate', $_POST["Birthdate"], PDO::PARAM_STR);
    $stmt->bindValue(':Contact_Number', $_POST["Contact_Number"], PDO::PARAM_STR);
    $stmt->bindValue(':Email', $_POST["Email"], PDO::PARAM_STR);
    $stmt->execute();

    $patientId = $pdo->lastInsertId();

    echo json_encode(array("status" => "success", "message" => "Data successfully added", "patientId" => $patientId));
} catch(PDOException $e) {
    echo json_encode(array("status" => "error", "message" => $e->getMessage()));
}
?>
