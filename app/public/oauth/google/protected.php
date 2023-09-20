<?php
include './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$authenticated = false;

if(isset($_COOKIE['codelab_google_access_token'])) {
    $api_url = 'https://openidconnect.googleapis.com/v1/userinfo';

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['codelab_google_access_token'],
        'Accept: application/json'
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    $user_data = json_decode($response, true);

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