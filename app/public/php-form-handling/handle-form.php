<?php

session_start();

$name = "";
$email = "";
$region = "";
$season = "";
$interests = [];
$participants = 0;
$message = "";
$token = "";

$data = [];

/*
Validation is highly important
Let's go through each of the fields and check them
*/

$errors = [];

// 0. Token

if(empty($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    $errors[] = "Invalid token";
}

// 1. Name - required, alphabets and spaces only

if(!empty($_POST['name'])) {
    $name = $_POST['name'];
    if(ctype_alpha(str_replace(" ", "", $name)) === false) {
        $errors[] = "Name should contain only alphabets and spaces";
    }
}
else {
    $errors[] = "Name field cannot be empty";
}

// 2. Email - required, validate using filter_var() function

if(!empty($_POST['email'])) {
    $email = $_POST['email'];
    if(filter_var($email, FILTER_VALIDATE_EMAIL) !== $email) {
        $errors[] = "Email is not valid";
    }
    
}
else {
    $errors[] = "Email can't be empty";
}

// 3. Region - required, value should be from the list

if(!empty($_POST['region'])) {
    $region = $_POST['region'];
    $allowed_regions = ["Asia", "Oceania", "Africa", "Europe", "North America", "Latin America"];
    if(!in_array($region, $allowed_regions)) {
        $errors[] = "Region not in list";
    }
}
else {
    $errors[] = "Select a region from the list";
}

// 4. Season - not required, but must be in the list if selected

if(!empty($_POST['season'])) {
    $season = $_POST['season'];
    $allowed_seasons = ["Summer", "Winter", "Spring", "Autumn", "Monsoon"];
    if(!in_array($season, $allowed_seasons)) {
        $errors[] = "Invalid Season";
    }
}

// 5. Interests - not required, but must be in the list if selected

if(!empty($_POST['interests'])) {
    $interests = $_POST['interests']; // this is also array
    $interests_allowed = ["Photography", "Trekking", "Star Gazing", "Bird Watching", "Camping"];

    foreach($interests as $interest) {
        if(!in_array($interest, $interests_allowed)) {
            $errors[] = "The activity you selected is not in our list";
            break;
        }
    }

}

// 6. Participants - required, must be between 1 and 10

if(!empty($_POST['participants'])) {
    $participants = (int)$_POST['participants'];
    if($participants < 1 || $participants > 10) {
        $errors[] = "No. of participants must be 1-10";
    }
}
else {
    $errors[] = "Specify the no. of participants";
}

// 7. Message - required, no html tags, js code, etc, just normal text

if(!empty($_POST['message'])) {
    // $message = htmlentities($_POST['message'], ENT_QUOTES, "UTF-8");
    // this is escaping, we'll do it while outputting
    $message = $_POST['message'];
}
else {
    $errors[] = "Tell about your requirements";
}



if ($errors) {

    $_SESSION['status'] = 'error';
    $_SESSION['errors'] = $errors;
    header('Location:index.php?result=validation_error');
    die();
    
}
else {

    $data = [
        "name" => $name,
        "email" => $email,
        "region" => $region,
        "season" => $season,
        "interests" => implode(", ", $interests),
        "participants" => $participants,
        "message" => $message
    ];

    $save = save_data($data);

    if($save[0]) {
        $_SESSION['status'] = 'success';
        $_SESSION['data'] = $data;
        header('Location:index.php?result=success');
        die();
    }
    else {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = [$save[1]];
        header('Location:index.php?result=save_error');
        die();
    }
    
}

function save_data($data) {
    
    try {
        $connection = new PDO("mysql:dbname=codelab;host=mysql", "root", "password");
    }
    catch (PDOException $connect_error) {
        return [false, "error connecting to database", $connect_error->getMessage()];
    }

    $sql = "CREATE TABLE if not exists `form_submissions` (
        `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255),
        `email` VARCHAR(255),
        `region` VARCHAR(255),
        `season` VARCHAR(255),
        `interests` VARCHAR(255),
        `participants` INT(11),
        `message` TEXT
    )";

    $connection->exec($sql);

    try {
        $stmt = $connection->prepare("INSERT INTO form_submissions (name, email, region, season, interests, participants, message) values (:name, :email, :region, :season, :interests, :participants, :message)");

        $stmt->bindParam(":name", $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(":region", $data['region'], PDO::PARAM_STR);
        $stmt->bindParam(":season", $data['season'], PDO::PARAM_STR);
        $stmt->bindParam(":interests", $data['interests'], PDO::PARAM_STR);
        $stmt->bindParam(":participants", $data['participants'], PDO::PARAM_INT);
        $stmt->bindParam(":message", $data['message'], PDO::PARAM_STR);

        $stmt->execute();
    }
    catch(PDOException $e) {
        return [false, "error saving data", $e->getMessage()];
    }
    return [true, "data saved", ""];
}


