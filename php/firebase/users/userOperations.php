<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation'])) {
    if ($_POST['operation'] == 'changePass') {
        echo updatePassword($_POST['userId'], $_POST['oldPass'], $_POST['newPass']);
    }
}

function getUser($userId, $requirePassword = false)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$userId?key=$apiKey";

    $currentUser = array();

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $responseObj = json_decode($response, true);

    // return $response;

    if (curl_errno($ch)) {
        return ('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    $temp = explode('/', $responseObj['name']);
    $currentUser['id'] = end($temp);

    foreach ($responseObj['fields'] as $key => $value) {
        if (isset($value['stringValue'])) {
            $currentUser[$key] = $value['stringValue'];
        } else if (isset($value['mapValue'])) {
            foreach ($value['mapValue']['fields'] as $subKey => $subValue) {
                if ($requirePassword == false && $subKey == 'password') {
                    continue;
                }
                $currentUser[$key][$subKey] = $subValue['stringValue'];
            }
        }
    }

    return json_encode($currentUser);
}

function updatePassword($userId, $currentPassword, $newPassword)
{
    include_once __DIR__ . '/firebaseAuth.php';
    include_once __DIR__ . '/../../general/sessionManagement.php';

    if ($currentPassword != getUserPassword($userId)) {
        return json_encode([
            'status' => '401',
            'message' => 'Incorrect Old Password',
        ]);
    }

    $idToken = getCurrentUserTokenFromSession();
    $firebaseResponse = json_decode(firebaseUpdatePassword($idToken, $newPassword), true);

    // if (!isset($firebaseResponse['idToken'])) {
    //     return json_encode($firebaseResponse);
    // }

    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/{$collection}/{$userId}?key={$apiKey}";

    $userData = json_decode(getUser($userId, true), true);
    $userData['credentials']['password'] = $newPassword;

    $updatedData = [
        "fields" => []
    ];

    foreach ($userData as $key => $value) {
        if ($key == 'id') continue;

        if (is_array($value)) {
            $fieldToPush = [
                "$key" => [
                    "mapValue" => [
                        "fields" => []
                    ],
                ],
            ];
            foreach ($value as $subKey => $subValue) {
                $subFieldToPush = [
                    "$subKey" => [
                        "stringValue" => "$subValue"
                    ],
                ];
                $fieldToPush["$key"]["mapValue"]["fields"] = array_merge($fieldToPush["$key"]["mapValue"]["fields"], $subFieldToPush);
            }
        } else {

            $fieldToPush = [
                "$key" => [
                    "stringValue" => "$value"
                ],
            ];
        }
        $updatedData["fields"] = array_merge($updatedData["fields"], $fieldToPush);
    }

    $updatedData = json_encode($updatedData);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updatedData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        return "Error: " . curl_error($ch);
    } else {
        return $firebaseResponse;
    }

    curl_close($ch);
}

function getUserPassword($userId)
{
    $currentUser = json_decode(getUser($userId, true), true);
    return $currentUser['credentials']['password'];
}

function checkAdmin($userId)
{
    $currentUser = json_decode(getUser($userId), true);
    return $currentUser['isAdmin'];
}
