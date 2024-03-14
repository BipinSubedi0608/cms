<?php

include "../firebase/users/firebaseAuth.php";
include "../firebase/users/userOperations.php";
include "./loadContent.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation'])) {

    if ($_POST['operation'] == 'login') {
        $email = isset($_POST["email"]) ? validate($_POST['email']) : "";
        $password = isset($_POST["password"]) ? validate($_POST['password']) : "";
        echo login($email, $password);
    } else if ($_POST['operation'] == 'logout') {
        echo logout();
    } else {
        echo "Invalid Operation.";
    }
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function login($email, $password)
{
    $response = json_decode(firebaseLogin($email, $password), true);
    if ($response['status'] == '200') {
        return getUser($response['userInfo']['id']);
    } else {
        return json_encode([
            'status' => $response['status'],
            'message' => $response['message'],
        ]);
    }
}

function logout()
{
    firebaseLogout();
    removeCurrentPage();
    return "Logout succesful";
}
