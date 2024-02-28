<?php

function getUser($userId)
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
                $currentUser[$key][$subKey] = $subValue['stringValue'];
            }
        }
    }

    return json_encode($currentUser);
}

function checkAdmin($userId)
{
    $currentUser = json_decode(getUser($userId), true);
    return json_encode($currentUser['isAdmin']);
}
