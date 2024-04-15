<?php

$clientId = 'aad53ff7-dfe5-422f-ad2b-d42d9e1400ec';
$clientSecret = 'hNH8Q~3pqrW1LXpGrMTAoUG8AaaG~zA96NoICbFW';
$scope = 'https://api.businesscentral.dynamics.com/.default';
$accessTokenUrl = 'https://login.microsoftonline.com/49f4f8df-cda6-43d8-bc84-f4a827a6536f/oauth2/v2.0/token';

$requestBody = [
    'grant_type' => 'client_credentials',
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'scope' => $scope
];

$ch = curl_init($accessTokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestBody));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(array('status' => 'error', 'message' => 'Error getting access token: ' . $error));
    exit;
}

$tokenResponse = json_decode($response);

if (isset($tokenResponse->error)) {
    echo json_encode(array('status' => 'error', 'message' => 'Error in access token response: ' . $tokenResponse->error_description));
    exit;
}

$accessToken = $tokenResponse->access_token;

$firstName = isset($_GET['First_Name']) ? strtolower($_GET['First_Name']) : "";
$surName = isset($_GET['Sur_Name']) ? strtolower($_GET['Sur_Name']) : "";
$mobilePhoneNo = isset($_GET['Mobile_Phone_No']) ? $_GET['Mobile_Phone_No'] : "";

if (empty($firstName) || empty($mobilePhoneNo) || empty($surName)) {
    echo json_encode(array('status' => 'error', 'message' => 'Mobile Phone Number is required.'));
    exit;
}

// Construct the API URL to fetch all data
$apiUrl = 'https://api.businesscentral.dynamics.com/v2.0/49f4f8df-cda6-43d8-bc84-f4a827a6536f/RSADEV/api/HobliIT/HobliITAPI/v1.0/Companies(b86020d9-3a45-ee11-8ebc-c26f954874aa)/LSCMemAccts/?$expand=LSCMemConts';

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken
]);

$apiResponse = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(array('status' => 'error', 'message' => 'Error calling the API: ' . $error));
    exit;
}

// Process API response
$apiData = json_decode($apiResponse, true);

if (!empty($apiData['value'])) {
    $recordCount = 0;
  
    foreach ($apiData['value'] as $record) {
        foreach ($record['lscMemConts'] as $contact) {
            if (
                isset($contact['mobilePhoneNo']) && strtolower($contact['mobilePhoneNo']) === strtolower($mobilePhoneNo) &&
                isset($contact['firstName']) && strtolower($contact['firstName']) === strtolower($firstName) &&
                isset($contact['surName']) && strtolower($contact['surName']) === strtolower($surName)
            ) {
                $patientId = $contact['accountNo'];
                $recordCount++;
            } else if (
                isset($contact['surName']) && strtolower($contact['surName']) === strtolower($surName) &&
                isset($contact['mobilePhoneNo']) && strtolower($contact['mobilePhoneNo']) === strtolower($mobilePhoneNo)
            ) {
                $patientId = $contact['accountNo'];
                $recordCount++;
            } else if (
                isset($contact['firstName']) && strtolower($contact['firstName']) === strtolower($firstName) 
            ) {
                $patientId = $contact['accountNo'];
                $recordCount++;
            }
        }
    }
  
    if ($recordCount > 1) {
        echo json_encode(array('status' => 'exists', 'message' => 'Multiple records with the provided details exist.', 'recordCount' => $recordCount));
    } elseif ($recordCount === 1) {
        echo json_encode(array('status' => 'exists', 'message' => 'A record with the provided details already exists.', 'patientId' => $patientId, 'recordCount' => $recordCount));
    } else {
        echo json_encode(array('status' => 'not_exists', 'message' => 'No record with the provided details found.'));
    }
} else {
    echo json_encode(array('status' => 'no_data', 'message' => 'No data found from the API.'));
}

?>
