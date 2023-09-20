<?php

/**
 * Here, we want to send another request
 * to fetch the user's profile details
 * name, avatar image
 */

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Dotenv\Dotenv;

include './vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// get the user's details

function getUser() {
    if(empty($_COOKIE['cr_github_access_token'])) {
        return false;
    }

    $apiUrl = "https://api.github.com/user";

    $client = new Client();

    try {
        $response = $client->get($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $_COOKIE['cr_github_access_token'],
                'Accept' => 'application/json',
            ]
        ]);

        if($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents());
        }
        return false;
    }
    catch(RequestException $e) {
        return false;
    }
}

$user = false;

$user = getUser();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protected Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <?php if(!empty($user)) : ?>
            <img src="<?= htmlspecialchars($user->avatar_url) ?>" alt="" class="rounded-circle">
            <h1 class="alert alert-success mt-4">Welcome, <?= htmlspecialchars($user->name); ?></h1>
        <?php else : ?>
            <div class="alert alert-danger">Authentication Required</div>
            <a href="signin.php" class="btn btn-primary btn-lg">Please Signin</a>
        <?php endif; ?>
    </div>
</body>
</html>