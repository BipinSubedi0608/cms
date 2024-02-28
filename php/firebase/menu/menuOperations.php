<?php

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
