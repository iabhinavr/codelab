<?php

$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];

echo "Original array is: <br>";

foreach($numbers as $n) {
    echo "$n ";
}

echo "<br><br>";

$count = 0;

include 'shufflenumbers.php';

echo "Let's try shuffling once again...<br><br>";

include 'shufflenumbers.php';