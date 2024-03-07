<?php
require 'config.php';

$sort = "SELECT * FROM customerdata WHERE Patient_ID IS NOT NULL";
	
if( isset($_REQUEST["search"]) && !empty($_REQUEST["search"]) ){
    $sort .= " 
        AND ( 
            FirstName LIKE :search OR 
            MiddleName LIKE :search OR 
            SurName LIKE :search OR
            Birthdate LIKE :search OR 
            ContactNumber LIKE :search OR
            Email LIKE :search
        )
    ";
}
try {
    $pdo = new PDO( $servername , $username, $password );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            
    $stmt = $pdo->prepare($sort);
    
    if( isset($_REQUEST["search"]) && !empty($_REQUEST["search"]) ){
        $searchTerm = '%' . $_REQUEST["search"] . '%';
        $stmt->bindValue( ':search', $searchTerm, PDO::PARAM_STR );
    }

    $stmt->execute(); 
    $stmt->rowCount()."^^^";

    if($stmt->rowCount() > 0) {
        echo '<table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">First Name</th>
                        <th scope="col">Middle Name</th>
                        <th scope="col">SurName</th>
                        <th scope="col">Birthdate</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>';
        
        while( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
            echo '<tr scope="row">
                    <td data-id="' . $row['FirstName'] . '">'.$row["FirstName"].'</td>
                    <td>'.$row["MiddleName"].'</td>
                    <td>'.$row["SurName"].'</td>
                    <td>'.$row["Birthdate"].'</td>
                    <td>'.$row["ContactNumber"].'</td>
                    <td>'.$row["Email"].'</td>
                    <td><button type="button" class="editBtn" id="editBtn_" data-toggle="modal" data-id="' . $row['Patient_ID'] . '">Edit</button></td>
                </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p style="text-align: center;color: gray;font-size: 16px;">No record found!</p>';
    }

} catch( PDOException $e ){
    echo $e->getMessage();
}

$pdo = null;
?>
