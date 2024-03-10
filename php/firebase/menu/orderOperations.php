<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operation'])) {
    switch ($_POST['operation']) {
        case 'create':
            echo createOrder($_POST['foodId']);
            break;

        default:
            echo "Invalid Operation";
            break;
    }
}

function getAllOrders()
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'orders';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection?key=$apiKey";
    $documents = array();

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $responseArray = json_decode($response, true)['documents'];

    if (curl_errno($ch)) {
        return ('Error: ' . curl_error($ch));
    }

    curl_close($ch);

    for ($i = 0; $i <  count($responseArray); $i++) {
        $temp = explode('/', $responseArray[$i]['name']);
        if (end($temp) == 'ASEx4l4vKK9lqhJnmgCm') continue; //Placeholder document is skipped

        $documents[$i] = [
            'id' => end($temp),
            'studentId' =>  $responseArray[$i]['fields']['studentId']['stringValue'],
            'foodId' =>  $responseArray[$i]['fields']['foodId']['stringValue'],
            'orderTime' =>  $responseArray[$i]['fields']['orderTime']['stringValue'],
            'isBought' =>  $responseArray[$i]['fields']['isBought']['stringValue'],
        ];
    }

    return json_encode($documents);
}



function getOrderWithId($orderId)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'orders';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$orderId?key=$apiKey";
    $orderDetails = array();

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $responseArray = json_decode($response, true);

    if (curl_errno($ch)) {
        return ('Error: ' . curl_error($ch));
    }

    curl_close($ch);

    $temp = explode('/', $responseArray['name']);

    $orderDetails = [
        'id' => end($temp),
        'studentId' =>  $responseArray['fields']['studentId']['stringValue'],
        'foodId' =>  $responseArray['fields']['foodId']['stringValue'],
        'orderTime' =>  $responseArray['fields']['orderTime']['stringValue'],
        'isBought' =>  $responseArray['fields']['isBought']['stringValue'],
    ];

    return json_encode($orderDetails);
}



function createOrder($foodId)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'orders';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection?key=$apiKey";

    include_once __DIR__ . "/../../general/sessionManagement.php";

    $studentId = getCurrentUserIdFromSession();

    $orderData = json_encode([
        "fields" => [
            "studentId" => [
                "stringValue" => $studentId,
            ],
            "foodId" => [
                "stringValue" => $foodId,
            ],
            "orderTime" => [
                "stringValue" => (string) time(),
            ],
            "isBought" => [
                "stringValue" => 'false',
            ],
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $orderData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    $responseObj = json_decode($response, true);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_errno($ch);
    }

    curl_close($ch);

    $temp = explode('/', $responseObj['name']);
    $orderDetails = [
        'id' => end($temp),
        'studentId' =>  $responseObj['fields']['studentId']['stringValue'],
        'foodId' =>  $responseObj['fields']['foodId']['stringValue'],
        'orderTime' =>  $responseObj['fields']['orderTime']['stringValue'],
        'isBought' =>  $responseObj['fields']['isBought']['stringValue'],
    ];

    return json_encode($orderDetails);
}
