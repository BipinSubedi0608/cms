<?php

include __DIR__ . "/../../general/sessionManagement.php";

function firebaseLogin($email, $password)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $url = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=$apiKey";

    $userDetails = [
        'email' => $email,
        'password' => $password,
        'returnSecureToken' => true
    ];

    $userDetailsJSON = json_encode($userDetails);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $userDetailsJSON);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $response = curl_exec($ch);
    $responseArray = json_decode($response, true);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);

    if (isset($responseArray['error'])) {
        return json_encode([
            'status' => $responseArray['error']['code'],
            'message' => $responseArray['error']['message'],
        ]);
    }

    $currentUser = [
        'id' => $responseArray['localId'],
        'email' => $responseArray['email'],
        'refreshToken' => $responseArray['refreshToken'],
        'idToken' =>  $responseArray['idToken'],
        'lastLoginTime' => time(),
    ];

    createSession('currentUser', $currentUser);

    return json_encode([
        'status' => '200',
        'message' => 'Logged in successfully',
        'userInfo' => $currentUser,
    ]);
}



function firebaseUpdatePassword($userId, $newPass)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $url = "https://identitytoolkit.googleapis.com/v1/accounts:update?key=$apiKey";

    $requestData = json_encode([
        'idToken' => $userId,
        'password' => $newPass,
        'returnSecureToken' => true,
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    curl_close($ch);

    return json_encode($response);
}



function firebaseLogout()
{
    destroySession();
}
