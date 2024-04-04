<?php

include_once __DIR__ . '/../../general/sessionManagement.php';
include_once __DIR__ . '/firebaseAuth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation'])) {
    switch ($_POST['operation']) {
        case 'changePass':
            $userId = getCurrentUserIdFromSession();
            echo updatePassword($userId, $_POST['oldPass'], $_POST['newPass']);
            break;

        case 'getUser':
            echo getUser($_POST['stdId']);
            break;

        case 'tradeId':
            echo getUserIdFromClgId($_POST['clgId']);
            break;

        case 'createUser':
            echo firebaseCreateUser($_POST['email'], $_POST['password']);
            break;

        case 'updateUser':
            echo updateUser($_POST['userId'], $_POST['userData']);
            break;

        case 'getSearchedUsers':
            echo getFilteredUser($_POST['toSearch'], $_POST['filterField']);
            break;

        default:
            echo "Invalid User Operation";
            break;
    }
}

function getUser($userId, $requirePassword = false)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$userId?key=$apiKey";

    $currentUser = array();

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $responseObj = json_decode($response, true);

    if (curl_errno($ch)) {
        return ('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    $temp = explode('/', $responseObj['name']);
    $currentUser['id'] = end($temp);

    foreach ($responseObj['fields'] as $key => $value) {
        if (isset($value['stringValue'])) {
            $currentUser[$key] = $value['stringValue'];
        } else if (isset($value['mapValue'])) {
            foreach ($value['mapValue']['fields'] as $subKey => $subValue) {
                if ($requirePassword == false && $subKey == 'password') {
                    continue;
                }
                $currentUser[$key][$subKey] = $subValue['stringValue'];
            }
        }
    }

    return json_encode($currentUser);
}


function sortedUserData($direction)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents:runQuery?key=$apiKey";


    $query = [
        "structuredQuery" => [
            "from" => [[
                "collectionId" => $collection,
                "allDescendants" => true
            ]],

            "orderBy" => [[
                "field" => [
                    "fieldPath" => "name"
                ],
                "direction" => "$direction"
            ]]
        ]
    ];


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);

    $responseArray = json_decode($response, true);

    if (curl_errno($ch)) {
        return ('Error: ' . curl_error($ch));
    }

    curl_close($ch);

    $sortedListOfUsers = []; // Initialize an empty array to store user data

    if (count($responseArray) > 0 && isset($responseArray[0]['document'])) {
        foreach ($responseArray as $document) {
            $user = $document['document'];

            // Skip adding user data if the name is "Admin"
            if ($user['fields']['name']['stringValue'] == 'Admin') {
                continue;
            }

            // Add user data to the $sortedListOfUsers array
            $sortedListOfUsers[] = [
                'name' => $user['fields']['name']['stringValue'],
                'std_id' => $user['fields']['std_id']['stringValue'],
                'faculty' => $user['fields']['faculty']['stringValue'],
                'grade' => $user['fields']['grade']['stringValue'],
                'section' => $user['fields']['section']['stringValue'],
            ];
        }
    }

    // Encode the array containing all user data into JSON format
    return json_encode($sortedListOfUsers);
}



function getUserIdFromClgId($clgId)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents:runQuery?key=$apiKey";

    $queryParams = [
        "structuredQuery" => [
            "from" => [[
                "collectionId" => $collection,
                "allDescendants" => true
            ]],

            "where" => [
                "fieldFilter" => [
                    "field" => [
                        "fieldPath" => "std_id"
                    ],
                    "op" => "EQUAL",
                    "value" => [
                        "stringValue" => "$clgId"
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

    if (count($responseArray) == 1 && (!isset($responseArray[0]['document']))) {
        return null;
    }

    $tempDoc = $responseArray[0]['document']['name'];
    $temp = explode("/", $tempDoc);
    $responseId = end($temp);

    return $responseId;
}



function getFilteredUser($filterValue, $filterField, $requirePassword = false)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents:runQuery?key=$apiKey";

    $listOfUsers = array();

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
                    "op" => "EQUAL",
                    "value" => [
                        "stringValue" => "$filterValue"
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

    if (count($responseArray) > 0 && isset($responseArray[0]['document'])) {
        $i = 0;
        foreach ($responseArray as $document) {
            $user = $document['document'];

            $temp = explode('/', $user['name']);
            $generalInfoTemp = $user['fields']['general_info']['mapValue']['fields'];
            $credentialsTemp = $user['fields']['credentials']['mapValue']['fields'];

            $listOfUsers[$i] = [
                'id' => end(($temp)),

                'name' => $user['fields']['name']['stringValue'],
                'std_id' => $user['fields']['std_id']['stringValue'],
                'faculty' => $user['fields']['faculty']['stringValue'],
                'grade' => $user['fields']['grade']['stringValue'],
                'isAdmin' => $user['fields']['isAdmin']['stringValue'],
                'section' => $user['fields']['section']['stringValue'],
                'general_info' => [
                    'dob' => $generalInfoTemp['dob']['stringValue'],
                    'gender' => $generalInfoTemp['gender']['stringValue'],
                    'roll_no' => $generalInfoTemp['roll_no']['stringValue'],
                    'father_name' => $generalInfoTemp['father_name']['stringValue'],
                    'mother_name' => $generalInfoTemp['mother_name']['stringValue'],
                ],

                'credentials' => [
                    'email' => $credentialsTemp['email']['stringValue'],
                    'phone' => $credentialsTemp['phone']['stringValue'],
                ],
            ];

            if ($requirePassword == true) {
                $listOfUsers[$i]['credentials']['password'] = $credentialsTemp['password']['stringValue'];
            }
        }
    }

    if (count($listOfUsers) > 0) {
        return json_encode($listOfUsers);
    } else {
        return "No user found";
    }
}



function createUserInitialInstance($localId, $email, $password)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$localId?key=$apiKey";

    $userData = json_encode([
        'fields' => [
            'credentials' => ['mapValue' => ['fields' => [
                'email' => ['stringValue' => $email],
                'password' => ['stringValue' => $password],
                'phone' => ['stringValue' => ''],
            ]]],
            'faculty' => ['stringValue' => ''],
            'grade' => ['stringValue' => ''],
            'isAdmin' => ['stringValue' => 'false'],
            'name' => ['stringValue' => ''],
            'section' => ['stringValue' => ''],
            'std_id' => ['stringValue' => ''],
            'general_info' => ['mapValue' => ['fields' => [
                'dob' => ['stringValue' => ''],
                'father_name' => ['stringValue' => ''],
                'gender' => ['stringValue' => ''],
                'mother_name' => ['stringValue' => ''],
                'roll_no' => ['stringValue' => ''],
            ]]],
        ]
    ]);

    //curl Init
    $ch = curl_init();

    //set curl operations
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Using PATCH to create a new document or update if exists
    curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    // Execute cURL session for Firestore document creation
    $firestore_response = curl_exec($ch);

    // Check for errors in Firestore document creation
    if ($firestore_response === false) {
        echo 'Firestore cURL error: ' . curl_error($ch);
    }
    // Close cURL session for Firestore document creation
    curl_close($ch);
}



function updateUser($userId, $newUserData)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$userId?key=$apiKey";

    $userFields = json_encode([
        'fields' => [
            'credentials' => ['mapValue' => ['fields' => [
                'email' => ['stringValue' => $newUserData['credentials']['email']],
                'password' => ['stringValue' => $newUserData['credentials']['password']],
                'phone' => ['stringValue' => $newUserData['credentials']['phone']],
            ]]],
            'faculty' => ['stringValue' => $newUserData['faculty']],
            'grade' => ['stringValue' => $newUserData['grade']],
            'isAdmin' => ['stringValue' => "false"],
            'name' => ['stringValue' => $newUserData['name']],
            'section' => ['stringValue' => $newUserData['section']],
            'std_id' => ['stringValue' => $newUserData['std_id']],
            'general_info' => ['mapValue' => ['fields' => [
                'dob' => ['stringValue' => $newUserData['general_info']['dob']],
                'father_name' => ['stringValue' => $newUserData['general_info']['father_name']],
                'gender' => ['stringValue' => $newUserData['general_info']['gender']],
                'mother_name' => ['stringValue' => $newUserData['general_info']['father_name']],
                'roll_no' => ['stringValue' => $newUserData['general_info']['roll_no']],
            ]]],
        ]
    ]);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $userFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}



function updatePassword($userId, $currentPassword, $newPassword)
{
    if ($currentPassword == $newPassword) {
        return json_encode([
            'status' => '402',
            'message' => 'New Password Cannot Be The Same As Old Password',
        ]);
    }

    if ($currentPassword != getUserPassword($userId)) {
        return json_encode([
            'status' => '401',
            'message' => 'Incorrect Old Password',
        ]);
    }

    $idToken = getCurrentUserTokenFromSession();
    $firebaseResponse = json_decode(firebaseUpdatePassword($idToken, $newPassword), true);

    if ($firebaseResponse["code"] != "200") {
        return json_encode([
            'status' => $firebaseResponse["code"],
            'message' => $firebaseResponse["message"],
        ]);
    }

    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/{$collection}/{$userId}?key={$apiKey}";

    $userData = json_decode(getUser($userId, true), true);
    $userData['credentials']['password'] = $newPassword;

    $updatedData = [
        "fields" => []
    ];

    foreach ($userData as $key => $value) {
        if ($key == 'id') continue;

        if (is_array($value)) {
            $fieldToPush = [
                "$key" => [
                    "mapValue" => [
                        "fields" => []
                    ],
                ],
            ];
            foreach ($value as $subKey => $subValue) {
                $subFieldToPush = [
                    "$subKey" => [
                        "stringValue" => "$subValue"
                    ],
                ];
                $fieldToPush["$key"]["mapValue"]["fields"] = array_merge($fieldToPush["$key"]["mapValue"]["fields"], $subFieldToPush);
            }
        } else {

            $fieldToPush = [
                "$key" => [
                    "stringValue" => "$value"
                ],
            ];
        }
        $updatedData["fields"] = array_merge($updatedData["fields"], $fieldToPush);
    }

    $updatedData = json_encode($updatedData);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updatedData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        return "Error: " . curl_error($ch);
    } else {
        return json_encode([
            'status' => '200',
            'message' => 'Password Changed Successfully',
        ]);
    }

    curl_close($ch);

}



function getUserPassword($userId)
{
    $currentUser = json_decode(getUser($userId, true), true);
    return $currentUser['credentials']['password'];
}



function checkAdmin($userId)
{
    $currentUser = json_decode(getUser($userId), true);
    return $currentUser['isAdmin'];
}
