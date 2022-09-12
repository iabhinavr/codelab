<?php

$count++;
echo "Shuffling $count...<br>";

shuffle($numbers);

foreach($numbers as $n) {
    echo "$n ";
}

echo "<br><br>";