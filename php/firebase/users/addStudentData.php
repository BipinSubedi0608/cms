<?php

// Function to handle Firestore API request
function updateFirestore($projectId, $collection, $localId, $fields) {
    $apiKey = 'AIzaSyAqp8-BgKCujREJeC54XR5cduGvbcjtuVs';
    $url = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents/$collection/$localId?key=$apiKey";
    
    $jsonFields = json_encode($fields);
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

// Function to handle form submission
function handleFormSubmission() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $faculty = $_POST['faculty'];
        $grade = $_POST['grade'];
        $std_id = $_POST['std_id'];
        $section = $_POST['section'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $father_name = $_POST['father_name'];
        $mother_name = $_POST['mother_name'];
        $gender = $_POST['gender'];
        $roll_no = $_POST['roll_no'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $projectId = 'cms-08-02-2024';
        $collection = 'users';
        $localId = $_POST['localId'];
        
        $fields = [
            'fields' => [
                'credentials' => ['mapValue' => ['fields' => [
                    'email' => ['stringValue' => $email],
                    'password' => ['stringValue' => $password],
                    'phone' => ['stringValue' => $phone],
                ]]],
                'faculty' => ['stringValue' => $faculty],
                'grade' => ['stringValue' => $grade],
                'isAdmin' => ['stringValue' => "false"],
                'name' => ['stringValue' => $name],
                'section' => ['stringValue' => $section],
                'std_id' => ['stringValue' => $std_id],
                'general_info' => ['mapValue' => ['fields' => [
                    'dob' => ['stringValue' => $dob],
                    'father_name' => ['stringValue' => $father_name],
                    'gender' => ['stringValue' => $gender],
                    'mother_name' => ['stringValue' => $mother_name],
                    'roll_no' => ['stringValue' => $roll_no],
                ]]],
            ]
        ];
        
        $response = updateFirestore($projectId, $collection, $localId, $fields);
        
        if ($response === false) {
            echo 'Error occurred while updating data in Firestore.';
        } else {
            echo 'Data updated in Firestore successfully.';
        }
    }
}

// Call the function to handle form submission
handleFormSubmission();
?>
