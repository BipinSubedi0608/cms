<?php

include "sessionManagement.php";

function firebaseLogin($email, $password)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $url = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=$apiKey";

    $userDetails = json_encode([
        'email' => $email,
        'password' => $password,
        'returnSecureToken' => true
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $userDetails);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $response = curl_exec($ch);
    $responseObj = json_decode($response, true);

    if (curl_errno($ch)) {
        return ('Curl error: ' . curl_error($ch));
    }

    if (!isset($responseObj['error'])) {
        $currentUser = [
            'id' => $responseObj['localId'],
            'email' => $responseObj['email'],
            'refreshToken' => $responseObj['refreshToken'],
            'lastLoginTime' => time(),
        ];

        $msg = createSession('currentUser', $currentUser);

        return json_encode([
            'status' => '200',
            'message' => 'Logged In Successfully',
            'userId' => $currentUser['id'],
            'msg' => $msg,
        ]);
    } else {
        return json_encode([
            'status' => $responseObj['error']['code'],
            'message' => $responseObj['error']['message'],
        ]);
    }
}

function firebaseLogout() {
    destroySession();
}
