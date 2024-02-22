<?php

const admin = [
    "email" => "admin@example.com",
    "password" => "admin@123"
];

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $response = [
        "email" => $_POST["email"],
        "password" => $_POST["password"],
        "rememberMe" => isset($_POST["remember_me"]) ? $_POST["remember_me"] : false,
        "isAdmin" => false
    ];

    $response["isAdmin"] = ($response["email"] == admin["email"] && $response["password"] == admin["password"]) ? true : false;

    echo json_encode($response);
    // echo "Hello";
}
