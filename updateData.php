<?php
require 'config.php';

if (isset($_POST["Patient_ID"])) {
    $patientId = $_POST["Patient_ID"];
    $firstName = $_POST["modalFirstName"];
    $middleName = $_POST["modalMiddleName"];
    $surName = $_POST["modalSurName"];
    $birthdate = $_POST["modalBirthdate"];
    $contactNumber = $_POST["modalContactNumber"];
    $email = $_POST["modalEmail"];

    try {
        $pdo = new PDO($servername, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("
            UPDATE customerdata 
            SET 
                `FirstName` = :FirstName,
                `MiddleName` = :MiddleName,
                `SurName` = :SurName,
                `Birthdate` = :Birthdate,
                `ContactNumber` = :ContactNumber,
                `Email` = :Email 
            WHERE 
                `Patient_ID` = :Patient_ID 
        ");
        $stmt->bindValue(':FirstName', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':MiddleName', $middleName, PDO::PARAM_STR);
        $stmt->bindValue(':SurName', $surName, PDO::PARAM_STR);
        $stmt->bindValue(':Birthdate', $birthdate, PDO::PARAM_STR);
        $stmt->bindValue(':ContactNumber', $contactNumber, PDO::PARAM_STR);
        $stmt->bindValue(':Email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':Patient_ID', $patientId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Data updated successfully.";

    } catch (PDOException $e) {
        echo "Error updating data: " . $e->getMessage();
    }

    $pdo = null;
} else {
    echo "Patient_ID not provided.";
}
?>
