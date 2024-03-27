<?php

//Session Life Time in seconds
$sessionLifeTime = 24 * 60 * 60;

ini_set('session.cookie_lifetime', $sessionLifeTime);
ini_set('session.gc-maxlifetime', $sessionLifeTime);
session_start();

function checkSession()
{
    global $sessionLifeTime;
    if (isset($_SESSION['currentUser'])) {
        $lastLoginTime = isset($_SESSION['currentUser']['lastLoginTime']) ? $_SESSION['currentUser']['lastLoginTime'] : 0;
        if ((time() - $lastLoginTime) < $sessionLifeTime) {
            return json_encode([
                'isLoggedIn' => 'true'
            ]);
        } else {
            return json_encode([
                'isLoggedIn' => 'false',
                'message' => 'Session Expired',
            ]);
        }
    } else {
        return json_encode([
            'isLoggedIn' => 'false',
            'message' => 'Not Logged In',
        ]);
    }
}

function refreshIdToken($refreshToken)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $url = "https://securetoken.googleapis.com/v1/token?key=$apiKey";

    $requestData = json_encode([
        'grant_type' => 'refresh_token',
        'refresh_token' => $refreshToken,
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
    $responseObj = json_decode($response, true);

    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    curl_close($ch);

    $_SESSION["currentUser"]["idToken"] = $responseObj["id_token"];
    $_SESSION["currentUser"]["refreshToken"] = $responseObj["refresh_token"];
}

function createSession($keyToStore, $dataToStore)
{
    $_SESSION[$keyToStore] = $dataToStore;
}

function getCurrentUserIdFromSession()
{
    return $_SESSION['currentUser']['id'];
}

function getCurrentUserTokenFromSession()
{
    return $_SESSION['currentUser']['idToken'];
}

function destroySession()
{
    session_unset();
    session_destroy();
}

function refreshSession()
{
    if (isset($_SESSION['currentUser'])) {
        $currentRefreshToken = $_SESSION['currentUser']['refreshToken'];
        $_SESSION['currentUser']['lastLoginTime'] = time();
        refreshIdToken($currentRefreshToken);
    }
}
