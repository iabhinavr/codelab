<?php

session_start();

$token = md5(uniqid(microtime(), true));
$_SESSION['token'] = $token;

include 'functions.php';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Tours & Travels</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Find Tours</h1>
        <?php if(isset($_SESSION['status']) && $_SESSION['status'] === 'error') : 
            $errors = $_SESSION['errors'];
        ?>
        <ul class="errors">
            <?php foreach($errors as $e) : ?>
                <li><?= $e ?></li>
            <?php endforeach; ?>
        </ul>
        <?php elseif(isset($_SESSION['status']) && $_SESSION['status'] === 'success') : 
            $data = $_SESSION['data'];
        ?>
        <div class="success">
            <p>Message sent successfully!</p>
            <p>Here are the details you entered:</p>
            <ul>
                <li>Name: <em><?= esc_str($data['name']) ?></em></li>
                <li>Email: <em><?= esc_str($data['email']) ?></em></li>
                <li>Season: <em><?= esc_str($data['season']) ?></em></li>
                <li>Region: <em><?= esc_str($data['region']) ?></em></li>
                <li>Interests: <em><?= esc_str($data['interests']) ?></em></li>
                <li>Participants: <em><?= esc_str($data['participants']) ?></em></li>
                <li>Message: <em><?= esc_str($data['message']) ?></em></li>
            </ul>
        </div>
        <div class="ideas">
            <h2>Here are some travel ideas based on the details you entered:</h2>
            <ul>
                <?php include('destinations.php'); ?>
                <?php foreach($destinations[$data['region']] as $d) : ?>
                    <li>
                        <a href="#"><img src="<?= $d[0] ?>" alt="<?= $d[1] ?>"></a>
                        <h3><?= $d[1] ?></h3>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <form action="handle-form.php" method="post">
            <div class="field-group">
                <label for="name" class="field-title">First Name:</label>
                <input type="text" name="name" id="name" placeholder="Enter your name">
            </div>
            <div class="field-group">
                <label for="email" class="field-title">Email:</label>
                <input type="email" name="email" id="email" placeholder="Enter email for contact">
            </div>
            <div class="field-group">
                <label for="region" class="field-title">Where would you like to go?</label>
                <select name="region" id="region">
                    <option value="">--Select a Region--</option>
                    <option value="Asia">Asia</option>
                    <option value="Oceania">Oceania</option>
                    <option value="Africa">Africa</option>
                    <option value="Europe">Europe</option>
                    <option value="North America">North America</option>
                    <option value="Latin America">Latin America</option>
                </select>
            </div>
            <div class="field-group">
                <p class="field-title">Preferred seaons:</p>
                <input type="radio" name="season" id="summer" value="Summer">
                <label for="summer">Summer</label>

                <input type="radio" name="season" id="winter" value="Winter">
                <label for="winter">Winter</label>

                <input type="radio" name="season" id="spring" value="Spring">
                <label for="spring">Spring</label>

                <input type="radio" name="season" id="autumn" value="Autumn">
                <label for="autumn">Autumn</label>

                <input type="radio" name="season" id="monsoon" value="Monsoon">
                <label for="monsoon">Monsoon</label>
            </div>
            <div class="field-group">
                <p class="field-title">Your interests:</p>
                <input type="checkbox" name="interests[]" id="photography" value="Photography">
                <label for="photography">Photography</label>

                <input type="checkbox" name="interests[]" id="trekking" value="Trekking">
                <label for="trekking">Trekking</label>

                <input type="checkbox" name="interests[]" id="star-gazing" value="Star Gazing">
                <label for="star-gazing">Star Gazing</label>

                <input type="checkbox" name="interests[]" id="bird-watching" value="Bird Watching">
                <label for="bird-watching">Bird Watching</label>

                <input type="checkbox" name="interests[]" id="camping" value="Camping">
                <label for="camping">Camping</label>
            </div>

            <div class="field-group">
                <label for="participants" class="field-title">No. of Participants</label>
                <input type="number" name="participants" id="participants">
            </div>
            <div class="field-group">
                <label for="message" class="field-title">Tell about your requirements:</label>
                <textarea name="message" id="message"></textarea>
            </div>
            <div class="field-group">
                <input type="hidden" name="token" value="<?= $token ?>">
                <button type="submit">Send</button>
            </div>
         
        </form>
    </div>
    
</body>
</html>

<?php

unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['data']);