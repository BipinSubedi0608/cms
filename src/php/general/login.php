<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? validate($_POST['email']) : "";
    $password = isset($_POST["password"]) ? validate($_POST['password']) : "";
    $rememberMe = isset($_POST["remember_me"]) ? $_POST["remember_me"] : false;

    login($email, $password, $rememberMe);
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function login($email, $password, $rememberMe)
{
    include "../firebase/users/firebaseLogin.php";
    include "../firebase/users/userOperations.php";

    $response = json_decode(firebaseLogin($email, $password), true);
    if ($response['status'] == '200') {
        echo getUser($response['userId']);
    } else {
        echo json_encode([
            'status' => $response['status'],
            'message' => $response['message'],
        ]);
    }
}
