<?php
function getAllUserCredentials($localId, $email, $password)
{
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $projectId = 'cms-08-02-2024';
    $collection = 'users';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$localId?key=$apiKey";

    $user_document_data = [
        'fields' => [
            'credentials' => ['mapValue' => ['fields' => [
                'email' => ['stringValue' => $email],
                'password' => ['stringValue' => $password],
                'phone' => ['stringValue' => ''],
            ]]],
            'faculty' => ['stringValue' => ''],
            'grade' => ['stringValue' => ''],
            'isAdmin' => ['stringValue' => 'false'],
            'name' =>['stringValue'=>''],
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
    ];

    //convert into json
    $jsonData = json_encode($user_document_data);
    $addUserArray = array();

    //curl Init
    $ch = curl_init();

    //set curl operations
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Using PATCH to create a new document or update if exists
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
       // Execute cURL session for Firestore document creation
       $firestore_response = curl_exec($ch);

       // Check for errors in Firestore document creation
       if ($firestore_response === false) {
           echo 'Firestore cURL error: ' . curl_error($ch);
       } else {
            $addUserArray[] = [
            'localId' =>$localId
            ];
            return json_encode($addUserArray);
       }

       // Close cURL session for Firestore document creation
       curl_close($ch);
}


