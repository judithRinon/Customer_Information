<?php

$clientId = 'aad53ff7-dfe5-422f-ad2b-d42d9e1400ec';
$clientSecret = 'hNH8Q~3pqrW1LXpGrMTAoUG8AaaG~zA96NoICbFW';
$scope = 'https://api.businesscentral.dynamics.com/.default';
$accessTokenUrl = 'https://login.microsoftonline.com/49f4f8df-cda6-43d8-bc84-f4a827a6536f/oauth2/v2.0/token';
$apiUrl = 'https://api.businesscentral.dynamics.com/v2.0/49f4f8df-cda6-43d8-bc84-f4a827a6536f/RSADEV/api/HobliIT/HobliITAPI/v1.0/Companies(b86020d9-3a45-ee11-8ebc-c26f954874aa)/LSCMemAccts?$expand=LSCMemConts';

$requestBody = [
    'grant_type' => 'client_credentials',
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'scope' => $scope
];

$tokenCh = curl_init($accessTokenUrl);
curl_setopt($tokenCh, CURLOPT_POST, true);
curl_setopt($tokenCh, CURLOPT_POSTFIELDS, http_build_query($requestBody));
curl_setopt($tokenCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($tokenCh, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

$tokenResponse = curl_exec($tokenCh);

if ($tokenResponse === false) {
    $error = curl_error($tokenCh);
    echo "cURL Error: " . $error;
    exit;
}

$tokenData = json_decode($tokenResponse, true);
$accessToken = $tokenData['access_token'];

curl_close($tokenCh);

$jsonData = null;
if (
    isset($_POST['First_Name']) &&
    isset($_POST['Middle_Name']) &&
    isset($_POST['Sur_Name']) &&
    isset($_POST['Mobile_Phone_No']) &&
    isset($_POST['eMail'])
) {
   

    $counterFile = 'pnt_code.txt';
    $counter = 0;
    if (file_exists($counterFile)) {
        $counter = intval(file_get_contents($counterFile));
    }
    
    
    $counter++;
    $no = 'PNTTEST' . str_pad($counter, 5, '0', STR_PAD_LEFT);
    
    file_put_contents($counterFile, $counter);
    
    $formData = array(
        'no' => $no, 
        'accountType' => 'Private', 
        'lscMemConts' => array(
            array(
                'accountNo' => $no, 
                'contactNo' => $_POST['Mobile_Phone_No'],
                'name' => $_POST['First_Name'] . ' ' . $_POST['Middle_Name'] . ' ' . $_POST['Sur_Name'],
                'firstName' => $_POST['First_Name'], 
                'middleName' => $_POST['Middle_Name'], 
                'surName' => $_POST['Sur_Name'],
                'mobilePhoneNo' =>  $_POST['Mobile_Phone_No'], 
                'eMail' => $_POST['eMail'] 
            )
        )
    );

    $jsonData = json_encode($formData);

} else {
    echo json_encode(array('status' => 'error', 'message' => 'One or more required parameters are missing.'));
}

$apiCh = curl_init($apiUrl);
curl_setopt($apiCh, CURLOPT_RETURNTRANSFER, true);
curl_setopt($apiCh, CURLOPT_POST, true);
curl_setopt($apiCh, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($apiCh, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
]);

$response = curl_exec($apiCh);

if ($response === false) {
    $error = curl_error($apiCh);
    echo json_encode(array('status' => 'error', 'message' => "cURL Error: $error"));
} else {
    $responseData = json_decode($response, true);
    if (isset($responseData['lscMemConts'][0]['accountNo'])) {
        $accountNo = $responseData['lscMemConts'][0]['accountNo'];
        echo json_encode(array('status' => 'success', 'accountNo' => $accountNo));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Account number not found in the response.'));
    }
}

curl_close($apiCh);

?>
