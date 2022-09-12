<?php

// Let's look at the frequently used ones

/*
if
else
elseif / else if
while
do-while
for
foreach
switch
break
return
include
include_once
require
require_once
*/

// if, else, elseif, else if

$score = 400;

if($score >= 1000) {
    echo "Wow! You've earned a golden badge";
}
elseif ($score < 1000 && $score >= 500) {
    echo "Great! You've earned a silver badge";
}
elseif($score < 500 && $score >= 100) {
    echo "Good job! You've earned bronze badge";
}
else {
    echo "You lost! play again";
}

// switch, break

$color = "white";

switch ($color) {
    case "red":
        echo "Apples are red";
        break;
    case "yellow":
        echo "mangoes are yellow";
        break;
    case "purple":
        echo "berries are purple";
        break;
    default:
        echo "fruits are great";
}

// the same thing using if else elseif

if ($color === "red") {
    echo "Apples are red";
}
elseif ($color === "yellow") {
    echo "mangoes are yellow";
}
elseif ($color === "purple") {
    echo "berries are purple";
}
else {
    echo "fruits are great"; 
}

echo "<br>";

// while loop

$target = 10;
$i = 0;

while ($i <= 10) {
    echo $i . " ";
    $i++;
}

echo "<br>";

$i = 0;

do {
    echo $i . " ";
    $i++;
} while ($i <= 10);

echo "<br>";

// while checks condition, then executes
// do-while executes first, then checks
// a more clear example

$feelingHappy = false;

while($feelingHappy) {
    echo "Go for a trip!";
    /*
    ...remaining code
    */
}

do {
    echo "Go for a trip!";
    /*
    ...remaining code
    */
} while($feelingHappy);

echo "<br>";

// for loop

$target = 15;

for ($i = 0; $i <= $target; $i++) {
    echo $i . " ";
}

echo "<br>";

// foreach - used to iterate arrays

$carDetails = [
    "color" => "blue",
    "maker" => "Audi",
    "automatic" => true,
    "gears" => 8,
    "seats" => 4
];

foreach($carDetails as $detail) {
    echo $detail;
    echo "<br>";
}

foreach($carDetails as $key => $value) {
    echo $key . ": " . $detail;
    echo "<br>";
}

