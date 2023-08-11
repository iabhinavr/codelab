<?php


if(!empty($_POST["name"]) && !empty($_POST["email"])) {
    echo json_encode(["status" => "success", "message" => "Profile data saved successfully"]);
}
else {
    echo json_encode(["status" => "error", "message" => "Required fields missing"]);
}