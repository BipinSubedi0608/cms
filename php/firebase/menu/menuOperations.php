<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation'])) {
    $operation = $_POST['operation'];
    switch ($operation) {
        case 'add':
            $foodName = isset($_POST['foodName']) ? $_POST['foodName'] : '';
            $foodQuantity = isset($_POST['foodQuantity']) ? $_POST['foodQuantity'] : '';
            $foodPrice = isset($_POST['foodPrice']) ? $_POST['foodPrice'] : '';

            echo addMenu($foodName, $foodQuantity, $foodPrice);
            break;

        case 'edit':
            if (isset($_POST['foodKey'])) {
                $foodKey = $_POST['foodKey'];
                editMenu($foodKey);
            }
            break;

        case 'delete':
            $foodId = isset($_POST['key']) ? $_POST['key'] : "";
            echo deleteMenu($foodId);
            break;

        default:
            echo "Invalid Operation";
            break;
    }
}



function getEntireMenu()
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
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
        if (end($temp) == 'iBRHonTyDScRSfJUcYJs') continue; //Placeholder document is skipped

        $documents[$i] = [
            'id' => end($temp),
            'name' =>  $responseArray[$i]['fields']['name']['stringValue'],
            'price' =>  $responseArray[$i]['fields']['price']['stringValue'],
            'quantity' =>  $responseArray[$i]['fields']['quantity']['stringValue'],
            'imgUrl' =>  $responseArray[$i]['fields']['imgUrl']['stringValue']
        ];
    }

    return json_encode($documents);
}



function addMenu($foodName, $foodQuantity, $foodPrice, $imageURL = "")
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection?key=$apiKey";

    $foodData = json_encode([
        "fields" => [
            "name" => ["stringValue" => $foodName],
            "quantity" => ["stringValue" => $foodQuantity],
            "price" => ["stringValue" => $foodPrice],
            "imgUrl" => ["stringValue" => $imageURL],
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $foodData);
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
    $food = [
        'id' => end($temp),
        'name' =>  $responseObj['fields']['name']['stringValue'],
        'price' =>  $responseObj['fields']['price']['stringValue'],
        'quantity' =>  $responseObj['fields']['quantity']['stringValue'],
        'imgUrl' =>  $responseObj['fields']['imgUrl']['stringValue']
    ];

    return json_encode($food);
}



function deleteMenu($foodId)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$foodId?key=$apiKey";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 200) {
            return "Document with ID {$foodId} deleted successfully.";
        } else {
            return "Error deleting document. HTTP code: {$http_code}";
        }
    }

    curl_close($ch);
}

function editMenu($foodKey)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
    $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/{$collection}/{$foodKey}?key={$apiKey}";

    if (isset($_POST['foodName']) && !empty($_POST['foodName'])) {
        $foodName = $_POST['foodName'];
        $foodQuantity = $_POST['foodQuantity'];
        $foodPrice = $_POST['foodPrice'];
    }

    $data = [
        "fields" => [
            "name" => [
                "stringValue" => $foodName,
            ],
            "quantity" => [
                "stringValue" => $foodQuantity,
            ],
            "price" => [
                "stringValue" => $foodPrice,
            ]
        ]
    ];

    $dataJson = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error: " . curl_error($ch);
    } else {
        return "Document updated successfully!";
    }

    // Close cURL session
    curl_close($ch);
}
