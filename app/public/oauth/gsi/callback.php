<?php

include './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$response_body = file_get_contents("php://input");

parse_str($response_body, $parsed_response_body);

if(!isset($parsed_response_body['credential'])) {
    echo 'credential missing';
    exit();
}

$credential = $parsed_response_body['credential'];

// $data = array(
//     'code' => $credential,
//     'client_id' => $_ENV['GOOGLE_CLIENT_ID'],
//     'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'],
//     'redirect_uri' => $_ENV['GOOGLE_REDIRECT_URI'],
//     'grant_type' => 'authorization_code',
// );

// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// $response = curl_exec($ch);

// curl_close($ch);

// $token_data = json_decode($response, true);

// if(isset($token_data['access_token'])) {
    setcookie('codelab_gsi_credential', $credential, httponly: true);
// }