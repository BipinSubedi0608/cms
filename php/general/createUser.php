<?php
include "../firebase/users/addUserData.php";

// Check if email and password are provided in the request
if (isset($_POST['email']) && isset($_POST['password'])) {
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $url = "https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=$apiKey";
    // Retrieve email and password from the POST data
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userDetails = json_encode([
        'email' => $email,
        'password' => $password,
        'returnSecureToken' => true,
    ]);

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $userDetails);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        echo 'cURL error: ' . curl_error($ch);
    } else {
        // Decode JSON response
        $responseObj = json_decode($response, true); // true to decode as array
        $localId  = $responseObj['localId'];
        echo getAllUserCredentials($localId, $email, $password);
    }

    // Close cURL session
    curl_close($ch);
}
