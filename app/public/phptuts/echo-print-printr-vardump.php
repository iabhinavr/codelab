<?php

/*
- echo is a language construct, not a function
- echo has no return values
- echo can accept multiple parameters, separated by commas
*/

echo "Hello World! Welcome to PHP";

echo "<br>";

echo "Hello ", "World ", "! ", "Welcome ", "to ", "PHP ";
echo "<br>";

$a = 8; $b = 17;

echo "Average of ", $a, " and ", $b, " is: ", ($a+$b)/2;

echo "<br>";

echo ((5 + 4)/3);

// however,

echo ("Hello "), ("World!"); //works, but
// echo ("Hello", "World!"); //error 

/*
 - print is also a language construct, not a function
 - return 1 unlike echo
 - can accept only 1 argument
 - can be used in expressions
*/

print "Hello World"; //works

// print "Hello", "World"; //error

$result = print "Hello";

var_dump($result);

$num = 5;

($num === 5) ? print "yes" : print "no";

print ((5 + 4)/3);

/*
- print_r() prints a variable in human-readable form
- can also return the output if the second argument is true
- does not ouput the data type of individual items in array, strings, and integers
*/

$fruit = [
    "name" => "apple",
    "color" => "red"
];

$result = "<pre>" . print_r($fruit, true) . "</pre>";

print_r($result);

/*
- var_dump() gives more details on data types
- xdebug can format it to make the output more readable
- no return value
- can
- have multiple parameters to dump
*/

$fruit = [
    "name" => "apple",
    "color" => "red",
    "weight" => 150
];

var_dump("hello", 5, $fruit);

