<?php

/*
In this video:
- functions, arguments, parameters
- pass by value and pass by reference
- type declarations
- default argument value
- return
*/

// functions are reusable blocks of code, makes the program efficient

// let's take a simple example, printing a message


function printMsg($msg) {
    $msg = "Hello, $msg <br>";
    print $msg;
}

$msg = "Let's learn PHP";
printMsg($msg);


// we want to find the LCM (lowest common multiple) of two numbers

echo "LCM of 4 and 7 is: ".findLCM(4, 7)."<br>";
echo "LCM of 3 and 4 is: ".findLCM(3, 4)."<br>";

function findLCM($n1, $n2) {

    if($n1 === $n2)
        return $n1;
    
    $lower = ($n1 < $n2) ? $n1 : $n2;
    $higher = ($n1 > $n2) ? $n1 : $n2;
    
    $lcm = null;

    for ($i = 1; $i <= $lower; $i++) {
        $multiple = $higher * $i;
        if(($multiple % $lower) === 0) {
            $lcm = $multiple;
            break;
        }     
    }

    return $lcm;
}

echo "LCM of 25 and 46 is: ".findLCM(25, 46)."<br>";