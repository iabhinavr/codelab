<?php
include './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Google_Client(['client_id' => $_ENV['GOOGLE_CLIENT_ID']]);

$authenticated = false;

if(isset($_COOKIE['codelab_gsi_credential'])) {

    $user_data = $client->verifyIdToken($_COOKIE['codelab_gsi_credential']);

    var_dump($user_data);

    if(
        isset($user_data['sub']) && 
        isset($user_data['name']) &&
        isset($user_data['given_name']) &&
        isset($user_data['picture']) &&
        isset($user_data['email'])
    ) {
        $authenticated = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if($authenticated) : ?>
        <img src="<?= $user_data['picture'] ?>" alt="">
        <h1>Welcome, <?= $user_data['given_name'] ?></h1>
    <?php else: ?>
        <a href="signin.php">Please login</a>
    <?php endif; ?>
</body>
</html>