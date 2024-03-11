<?php

include_once __DIR__ . "/../../general/sessionManagement.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation'])) {
    $operation = $_POST['operation'];
    switch ($operation) {
        case 'add':
            $imgUrl = (isset($_POST['imgUrl']) && !empty($_POST['imgUrl'])) ? $_POST['imgUrl'] : __DIR__ . '/../../../assets/images/Image-Input.jpg';
            $foodName = isset($_POST['name']) ? $_POST['name'] : '';
            $foodQuantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
            $foodPrice = isset($_POST['price']) ? $_POST['price'] : '';

            echo addMenu($foodName, $foodQuantity, $foodPrice, $imgUrl);
            break;

        case 'edit':
            $foodId = isset($_POST['foodId']) ? $_POST['foodId'] : '';
            $imgUrl = (isset($_POST['imgUrl']) && !empty($_POST['imgUrl'])) ? $_POST['imgUrl'] : __DIR__ . '/../../../assets/images/Image-Input.jpg';
            $foodName = isset($_POST['name']) ? $_POST['name'] : '';
            $foodQuantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
            $foodPrice = isset($_POST['price']) ? $_POST['price'] : '';

            echo editMenu($foodId, $imgUrl, $foodName, $foodQuantity, $foodPrice);
            break;

        case 'delete':
            $foodId = isset($_POST['foodId']) ? $_POST['foodId'] : "";
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
        if ($responseArray[$i]['fields']['isDeleted']['stringValue'] == 'true')  continue; //Deleted documents are skipped

        $documents[$i] = [
            'id' => end($temp),
            'name' =>  $responseArray[$i]['fields']['name']['stringValue'],
            'price' =>  $responseArray[$i]['fields']['price']['stringValue'],
            'quantity' =>  $responseArray[$i]['fields']['quantity']['stringValue'],
            'imgUrl' =>  $responseArray[$i]['fields']['imgUrl']['stringValue'],
            'lastUpdatedTime' => $responseArray[$i]['fields']['lastUpdatedTime']['stringValue'],
            'isDeleted' => $responseArray[$i]['fields']['isDeleted']['stringValue'],
        ];
    }

    return json_encode($documents);
}



function getFoodWithId($foodId)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$foodId?key=$apiKey";
    $food = array();

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

    $food = [
        'id' => end($temp),
        'name' =>  $responseArray['fields']['name']['stringValue'],
        'price' =>  $responseArray['fields']['price']['stringValue'],
        'quantity' =>  $responseArray['fields']['quantity']['stringValue'],
        'imgUrl' =>  $responseArray['fields']['imgUrl']['stringValue'],
        'lastUpdatedTime' => $responseArray['fields']['lastUpdatedTime']['stringValue'],
        'isDeleted' => $responseArray['fields']['isDeleted']['stringValue'],
    ];

    return json_encode($food);
}



function getFilteredMenu($lastCheckedTime)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents:runQuery?key=$apiKey";

    $documents = array();

    $queryParams = [
        "structuredQuery" => [
            "from" => [[
                "collectionId" => $collection,
                "allDescendants" => true
            ]],

            "where" => [
                "fieldFilter" => [
                    "field" => [
                        "fieldPath" => 'lastUpdatedTime'
                    ],
                    "op" => "GREATER_THAN_OR_EQUAL",
                    "value" => [
                        "stringValue" => "$lastCheckedTime",
                    ]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($queryParams));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    $responseArray = json_decode($response, true);

    if (curl_errno($ch)) {
        return ('Error: ' . curl_error($ch));
    }

    curl_close($ch);

    // return json_encode($responseArray);

    if (count($responseArray) > 1) {
        $i = 0;
        foreach ($responseArray as $document) {
            $doc = $document['document'];

            $temp = explode('/', $doc['name']);

            if (end($temp) == 'iBRHonTyDScRSfJUcYJs') continue; //Placeholder document is skipped

            $documents[$i] = [
                'id' => end($temp),
                'name' =>  $doc['fields']['name']['stringValue'],
                'price' =>  $doc['fields']['price']['stringValue'],
                'quantity' =>  $doc['fields']['quantity']['stringValue'],
                'imgUrl' =>  $doc['fields']['imgUrl']['stringValue'],
                'lastUpdatedTime' =>  $doc['fields']['lastUpdatedTime']['stringValue'],
                'isDeleted' => $doc['fields']['isDeleted']['stringValue'],
            ];
            $i++;
        }
    }

    return json_encode($documents);
}



function addMenu($foodName, $foodQuantity, $foodPrice, $imageURL)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection?key=$apiKey";

    $foodData = json_encode([
        "fields" => [
            "name" => [
                "stringValue" => $foodName
            ],
            "quantity" => [
                "stringValue" => $foodQuantity
            ],
            "price" => [
                "stringValue" => $foodPrice
            ],
            "imgUrl" => [
                "stringValue" => $imageURL
            ],
            "isDeleted" => [
                "stringValue" => 'false'
            ],
            "lastUpdatedTime" => [
                "stringValue" => (string) time()
            ],
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
    $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/{$collection}/{$foodId}?key={$apiKey}";

    $foodToBeDeleted = getFoodWithId($foodId);

    $data = json_encode([
        "fields" => [
            "imgUrl" => [
                "stringValue" => $foodToBeDeleted['imgUrl'],
            ],
            "name" => [
                "stringValue" => $foodToBeDeleted['name'],
            ],
            "quantity" => [
                "stringValue" => $foodToBeDeleted['quantity'],
            ],
            "price" => [
                "stringValue" => $foodToBeDeleted['price'],
            ],
            "isDeleted" => [
                "stringValue" => 'true',
            ],
            "lastUpdatedTime" => [
                "stringValue" => (string) time(),
            ],
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error: " . curl_error($ch);
    } else {
        return "Document deleted successfully!";
    }

    // Close cURL session
    curl_close($ch);
}



function editMenu($foodKey, $foodImage, $foodName, $foodQuantity, $foodPrice)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'menu';
    $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/{$collection}/{$foodKey}?key={$apiKey}";

    $data = json_encode([
        "fields" => [
            "imgUrl" => [
                "stringValue" => $foodImage,
            ],
            "name" => [
                "stringValue" => $foodName,
            ],
            "quantity" => [
                "stringValue" => $foodQuantity,
            ],
            "price" => [
                "stringValue" => $foodPrice,
            ],
            "isDeleted" => [
                "stringValue" => 'false',
            ],
            "lastUpdatedTime" => [
                "stringValue" => (string) time(),
            ],
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
