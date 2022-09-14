<?php
declare(strict_types=1);

/*
In this video:
- php has both built-in and user-defined functions
- functions, arguments, parameters
- pass by value and pass by reference
- type declarations
- default argument value
- return
*/

// Here are some examples of user-defined functions

$numbers = [4, 5, 2, 7, 3];

var_dump($numbers);
sort($numbers);
var_dump($numbers);

$name = "abhinav";
var_dump($name);

$name = strtoupper($name);
var_dump($name);

// user-defined functions
// functions are reusable blocks of code, makes the program efficient

// let's take a simple example, printing a message


function printMsg(&$msg) {
    $msg = "Hello, $msg <br>";
    print $msg;
}

$msg = "Let's learn PHP";
$result = printMsg($msg);

var_dump($result);

// function to find average, using type declarations

function findAverage(int $n1, int $n2) : float  {
    $avg = ($n1+$n2)/2;
    return (float) $avg;
}

$result = findAverage(8, 10);
var_dump($result);


// we want to find the LCM (lowest common multiple) of two numbers

function findLCM(int $n1, int $n2) : int  {

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

echo "LCM of 4 and 6 is: ".findLCM(4, 6)."<br>";
echo "LCM of 25 and 46 is: ".findLCM(25, 46)."<br>";