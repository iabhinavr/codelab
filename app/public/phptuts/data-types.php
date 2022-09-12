<?php

// 1. Booleans - true or false value

$check = true;

var_dump($check);
echo gettype($check);
echo '<br>';

// 2. Integers 

/*
- negative or positive integers, and zero
- can be decimal, binary, octal, or hexadecimal
*/

$score1 = 80;
var_dump($score1);

$score2 = -25;
var_dump($score2);

var_dump($score1 + $score2);

// 3. Floats - decimal numbers

$average = ($score1+$score2)/2;
var_dump($average);
var_dump((int)$average);



// 4. Strings

/*
- is a sequence of characters, each 1 byte in size
- double quotes, single quotes, heredoc, or nowdoc
*/


$person = "Abhinav";
$channel = 'Coding Reflections';

$message = "$person is recording a video for $channel";
$message2 = '$person is recording a video for $channel';

echo $message;
echo '<br>';
echo $message2;
echo '<br>';

$codeBlock = <<< HERE
<pre>
    if(true) {
        echo "hello world!";
        echo "second line";
        if(true) {
            echo "third line";
        }
     }
</pre>
HERE;
echo $codeBlock;

$codeBlock = <<< 'NOW'
<pre>
    $a = true;
    if($a) {
        echo "hello world!";
        echo "second line";
        if(true) {
            echo "third line";
        }
     }
</pre>
NOW;
echo $codeBlock;

// 5. Arrays

$fruits = array("apple", "orange", "mango");

var_dump($fruits);

$fruit = array(
    "name" => "apple",
    "color" => "red"
); // associative array

var_dump($fruit);

$fruit = [
    "name" => "mango",
    "color" => "yellow"
];

var_dump($fruit);

// 6. Object

class Camera {
    public $maker;
    
    public function __construct($maker) {
        $this->maker = $maker;
    }

    public function getMaker() {
        return $maker;
    }
}

$myCamera = new Camera('Nikon');
var_dump($myCamera);

$yourCamera = new Camera('Canon');
var_dump($yourCamera);

// 7. Iterables

$fruits = array("apple", "orange", "mango");

// $fruits = "apple and mango";

function getFruits(iterable $iterable) {
    // var_dump($iterable);
    foreach ($iterable as $key => $value) {
        echo $key+1 . ") " . $value;
        echo "<br>";
    }
}

getFruits($fruits);

// 8. Callable

function printHello() {
    echo "Hello";
}

function callFn(callable $fn) {
    $fn();
}

$functionName = "printHello";
// $functionName = "sayHello";

callFn($functionName);

// 9. Null - no value data type

$nothing = NULL;

var_dump($nothing);

// 10. Resource

$handle = fopen("some.txt", "w");

var_dump($handle);