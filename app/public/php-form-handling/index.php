<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Travel Packages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Find Tours</h1>
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] === 'error') : 
        $errors = $_SESSION['errors'];
        ?>
        <ul class="errors">
            <?php foreach($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif(isset($_SESSION['status']) && $_SESSION['status'] === 'success') : 
        $data = $_SESSION['data'];
        ?>
        <div class="success">
            <p>Message sent successfully!</p>
            <p>Here are the details you entered:</p>
            <ul>
                <li>Name: <em><?= $data['firstname']?></em></li>
                <li>Email: <em><?= $data['email']?></em></li>
                <li>Season: <em><?= $data['season']?></em></li>
                <li>Region: <em><?= $data['region']?></em></li>
                <li>Interests: <em><?php echo $data['interests']; ?></em></li>
                <li>Participants: <em><?= $data['participants']?></em></li>
                <li>Message: <em><?= $data['message']?></em></li>
            </ul>
        </div>
        <div class="ideas">
            <h2>Here are some travel ideas:</h2>
            <ul>
                <?php include('destinations.php'); ?>
                <?php foreach($destinations[$data['region']] as $d) : ?>
                    <li>
                        <a href="#"><img src="<?= $d[0] ?>" alt=""></a>
                        <h3><?= $d[1] ?></h3>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
    <?php endif; ?>
    <form action="handle-form.php" method="post">
        <div class="field-group">
            <label for="firstname" class="field-title">Name:</label>
            <input type="text" name="firstname" value="" placeholder="First name or Nickname">
        </div>
        <div class="field-group">
            <label for="email" class="field-title">Email:</label>
            <input type="email" name="email" placeholder="Email for contact">
        </div>
        <div class="field-group">
            <label for="region" class="field-title">Where would you like to visit?</label>
            <select name="region" id="region">
                <option value="Asia">Asia</option>
                <option value="Oceania">Oceania</option>
                <option value="Africa">Africa</option>
                <option value="Europe">Europe</option>
                <option value="North America">North America</option>
                <option value="Latin America">Latin America</option>
            </select>
        </div>
        <div class="field-group">
            <p class="field-title">Preferred season:</p>
            <input type="radio" id="summer" name="season" value="Summer">
            <label for="summer">Summer</label>
            <input type="radio" id="winter" name="season" value="Winter">
            <label for="winter">Winter</label>
            <input type="radio" id="spring" name="season" value="Spring">
            <label for="spring">Spring</label>
            <input type="radio" id="autumn" name="season" value="Autumn">
            <label for="autumn">Autumn</label>
            <input type="radio" id="Monsoon" name="season" value="Monsoon">
            <label for="monsoon">Monsoon</label>
        </div>
        <div class="field-group">
            <p class="field-title">Your interests:</p>
            <input type="checkbox" id="photography" name="interests[]" value="Photography">
            <label for="photography">Photography</label>
            <input type="checkbox" id="trekking" name="interests[]" value="Trekking">
            <label for="trekking">Trekking</label>
            <input type="checkbox" id="star-gazing" name="interests[]" value="Star Gazing">
            <label for="star-gazing">Star Gazing</label>
            <input type="checkbox" id="bird-watching" name="interests[]" value="Bird Watching">
            <label for="bird-watching">Bird Watching</label>
            <input type="checkbox" id="camping" name="interests[]" value="Camping">
            <label for="camping">Camping</label>
        </div>
        <div class="field-group">
            <label for="participants" class="field-title">No. of participants:</label>
            <input type="number" name="participants" id="participants" value="1">
        </div>
        <div class="field-group">
            <label for="message" class="field-title">Mention specific requirements:</label>
            <textarea name="message" id="message"></textarea>
        </div>
        <div class="field-group">
            <input type="hidden" name="token" value="">
            <input type="submit" name="" value="Send">
        </div>      
    </form>
    </div>
</body>
</html>

<?php

unset($_SESSION['status']);
unset($_SESSION['errors']);