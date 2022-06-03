<?php

session_start();

$firstname = "";
$email = "";
$region = "";
$season = "";
$interests = [];
$participants = 0;
$message = "";
$token = "";

$errors = [];

if(!empty($_POST['firstname'])) {
    $firstname = $_POST['firstname'];
    if(!ctype_alpha($firstname)) {
        $errors[] = "Name should contain only alphabets";
    }
}
else {
    $errors[] = "Name field cannot be empty";
}

if(!empty($_POST['email'])) {
    $email = $_POST['email'];
    $sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $email != $sanitized_email) {
        $errors[] = "Please enter a valid email" . $sanitized_email;
    }
}
else {
    $errors[] = "Email field cannot be empty";
}

if(!empty($_POST['region'])) {
    $region = $_POST['region'];
    $regions = ["Asia", "Oceania", "Africa", "Europe", "North America", "Latin America"];
    if(!in_array($region, $regions)) {
        $errors[] = "Region not in list";
    }
}
else {
    $errors[] = "Select a region from the list";
}

if(!empty($_POST['season'])) {
    $season = $_POST['season'];
    $seasons = ["Summer", "Winter", "Spring", "Autumn", "Monsoon"];
    if(!in_array($season, $seasons)) {
        $errors[] = "Invalid season";
    }
}

if(!empty($_POST['interests'])) {
    $interests = $_POST['interests'];
    $interests_allowed = ["Photography", "Trekking", "Star Gazing", "Bird Watching", "Camping"];
    foreach($interests as $interest) {
        if(!in_array($interest, $interests_allowed)) {
            $errors[] = "Please select an interest from the list";
            break;
        }
    }
}

if(!empty($_POST['participants'])) {
    $participants = (int)$_POST['participants'];
    if($participants < 1 || $participants > 10) {
        $errors[] = "Participants should be 1-10";
    }
}
else {
    $errors[] = "Specify the no. of participants";
}

if(!empty($_POST['message'])) {
    $message = htmlentities($_POST['message'], ENT_QUOTES, "UTF-8");
}
else {
    $errors[] = "Tell about your requirements";
}

if($errors) {  
    $_SESSION['status'] = 'error';
    $_SESSION['errors'] = $errors;
    header('Location:index.php?result=validation_error');
    die();
}
else {

    $data = [
        "firstname" => $firstname,
        "email" => $email,
        "region" => $region,
        "season" => $season,
        "interests" => implode(",", $interests),
        "participants" => $participants,
        "message" => $message
    ];

    $save = save_data($data);

    if($save[0]) {
        $_SESSION['data'] = $data;
        $_SESSION['status'] = 'success';
        header('Location:index.php?result=success');
        die();
    }
    else {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $save[1];
        header('Location:index.php?result=save_error');
        die();
    }
    
}

function save_data($data) {
    $connection = new PDO('mysql:dbname=travel;host=mysql', "root", "password", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    try {
        $stmt = $connection->prepare("INSERT INTO contacts (firstname, email, region, season, interests, participants, message) values (:firstname, :email, :region, :season, :interests, :participants, :message)");

        $stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':region', $data['region'], PDO::PARAM_STR);
        $stmt->bindParam(':season', $data['season'], PDO::PARAM_STR);
        $stmt->bindParam(':interests', $data['interests'], PDO::PARAM_STR);
        $stmt->bindParam(':participants', $data['participants'], PDO::PARAM_STR);
        $stmt->bindParam(':message', $data['message'], PDO::PARAM_STR);
    
        $stmt->execute();
    }
    catch(PDOException $e) {
        return [false, $e->getMessage()];
    }
    return [true, 'saved'];
    
}