<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['orderOperation'])) {
    switch ($_POST['orderOperation']) {
        case 'create':
            echo createOrder($_POST['foodId']);
            break;

        case 'get':
            echo getOrderWithId($_POST['orderId']);
            break;

        case 'reference':
            echo getOrdersByStdId($_POST['stdId'], $_POST['isHistory']);
            break;

        case 'confirm':
            echo confirmOrder($_POST['orderId']);
            break;

        default:
            echo "Invalid Order Operation";
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



function getFilteredOrders($filterField, $filterValue, $op)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'orders';
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
                        "fieldPath" => "$filterField"
                    ],
                    "op" => "$op",
                    "value" => [
                        "stringValue" => "$filterValue"
                    ]
                ]
            ],

            "orderBy" => [[
                "field" => [
                    "fieldPath" => "orderTime"
                ],
                "direction" => "DESCENDING"
            ]]
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

    // return $response;

    if (curl_errno($ch)) {
        return ('Error: ' . curl_error($ch));
    }

    curl_close($ch);

    if (count($responseArray) > 0 && isset($responseArray[0]['document'])) {
        $i = 0;
        foreach ($responseArray as $document) {
            $doc = $document['document'];

            $temp = explode('/', $doc['name']);

            if (end($temp) == 'ASEx4l4vKK9lqhJnmgCm') continue; //Placeholder document is skipped

            $documents[$i] = [
                'id' => end($temp),
                'foodId' =>  $doc['fields']['foodId']['stringValue'],
                'studentId' =>  $doc['fields']['studentId']['stringValue'],
                'isBought' =>  $doc['fields']['isBought']['stringValue'],
                'orderTime' =>  $doc['fields']['orderTime']['stringValue'],
            ];
            $i++;
        }
    }

    return json_encode($documents);
}



function getOrdersByStdId($stdId, $isHistory = 'false')
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'orders';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents:runQuery?key=$apiKey";

    $timestamp_12am = strtotime(date('Y/m/d') . ' 00:00:00');

    $queryParams = [
        "structuredQuery" => [
            "from" => [[
                "collectionId" => $collection,
                "allDescendants" => true
            ]],

            "where" => [
                "compositeFilter" => [
                    "op" => "AND",
                    "filters" => [
                        [
                            "fieldFilter" => [
                                "field" => [
                                    "fieldPath" => "studentId"
                                ],
                                "op" => "EQUAL",
                                "value" => [
                                    "stringValue" => "$stdId"
                                ]
                            ]
                        ],
                        [
                            "fieldFilter" => [
                                "field" => [
                                    "fieldPath" => "orderTime"
                                ],
                                "op" => ($isHistory == 'false' ? "GREATER_THAN_OR_EQUAL" : "LESS_THAN"),
                                "value" => [
                                    "stringValue" => (string) $timestamp_12am
                                ]
                            ]
                        ]
                    ]
                ]
            ],

            "orderBy" => [[
                "field" => [
                    "fieldPath" => "orderTime"
                ],
                "direction" => "DESCENDING"
            ]]
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
    $listOfFilteredOrders = array();

    if (curl_errno($ch)) {
        return ('Error: ' . curl_error($ch));
    }

    curl_close($ch);

    if (count($responseArray) > 0 && isset($responseArray[0]['document'])) {
        $i = 0;
        foreach ($responseArray as $document) {
            $temp = explode('/', $document['document']['name']);

            if (end($temp) == 'ASEx4l4vKK9lqhJnmgCm') continue; //Placeholder document is skipped

            $listOfFilteredOrders[$i] = [
                'id' => end($temp),
                'foodId' =>  $document['document']['fields']['foodId']['stringValue'],
                'studentId' =>  $document['document']['fields']['studentId']['stringValue'],
                'orderTime' =>  $document['document']['fields']['orderTime']['stringValue'],
                'isBought' =>  $document['document']['fields']['isBought']['stringValue'],
            ];
            $i++;
        }
    }

    return json_encode($listOfFilteredOrders);
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
    include_once __DIR__ . "/menuOperations.php";

    $studentId = getCurrentUserIdFromSession();
    $orderFoodData = json_decode(getFoodWithId($foodId), true);

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

    editMenu(
        $foodId,
        $orderFoodData['imgUrl'],
        $orderFoodData['name'],
        $orderFoodData['quantity'] - 1,
        $orderFoodData['price']
    );

    return json_encode($orderDetails);
}



function confirmOrder($orderId)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'orders';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$orderId?key=$apiKey";

    $orderDetails = json_decode(getOrderWithId($orderId), true);

    // Fields to update
    $updatedOrderDetails = json_encode([
        "fields" => [
            "studentId" => [
                "stringValue" => $orderDetails['studentId'],
            ],
            "foodId" => [
                "stringValue" => $orderDetails['foodId'],
            ],
            "orderTime" => [
                "stringValue" => $orderDetails['orderTime'],
            ],
            "isBought" => [
                "stringValue" => 'true',
            ],
        ]
    ]);

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updatedOrderDetails);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
    ]);

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Display the response
    return $response;
}
