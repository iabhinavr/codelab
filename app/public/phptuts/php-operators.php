<?php

// 1. Arithmetic Operators

$num1 = 5;
$num2 = 3;

$addition = $num1 + $num2;
$subtraction = $num1 - $num2;
$multiplication = $num1 * $num2;
$division = $num1 / $num2;
$modulus = $num1 % $num2;
$exponentiation = $num1 ** $num2;

var_dump($addition);
var_dump($subtraction);
var_dump($multiplication);
var_dump($division);
var_dump($modulus);
var_dump($exponentiation);


// 2. Assignment Operators

$x = 4;
$y = 3;
$z = 2;

$z = $x; // assigns the value of $x to $z, now $z = 4

$x += $y; // means $x = $x + $y
echo $x;

// 3. Comparison Operators

$a = true;
$b = 1;

$c = ($a == $b); // true because of (boolean) 1 = true
var_dump($c);

/*
so, the operators are:
== equal
=== equal and identical type
!= not equal
!== not equal or not same type
> greater than
< less than
>= greater than or equal to
<= less than or equal to
<=> spaceship operator
*/

$a = 8;
$b = 6;

var_dump($a > $b); // returns true

var_dump($a <=> $b); // returns 1
var_dump($b <=> $a); // returns -1
var_dump($a <=> $a); // returns 0

// ternary operator

$result = ($a > $b) ? "a is larger" : "b is larger";
echo $result, "<br>";
$larger = ($a > $b) ? $a : $b;

// 4. Increment / Decrement Operators

$a = 1;

var_dump($a++); //prints 1;
var_dump($a); // prints 2

var_dump(++$a); // prints 3;

var_dump($a--); // prints 3;
var_dump(--$a); //prints 1;

// 5. Logical Operators

$x = true; $y = false; $z = true;

var_dump($x && $y);
var_dump($x && $z);

var_dump($x || $y);
var_dump($x || $z);

var_dump(!$x);

// 6. String Operators

$str1 = "Hello ";
$str2 = "World";

$str1 .= $str2; // means $str1 = $str1 . $str2 - concatenation

// 7. Array Operators

$fruits1 = [
    0 => "apple", 
    1 => "orange", 
    2 => "mango"
];
$fruits2 = [
    3 => "jackfruit", 
    4 => "papaya", 
    5 => "guava"
];

$allFruits = $fruits1 + $fruits2;

var_dump($allFruits);

/*
== equality: same values
=== equality: same values, orders, types
!= inequality
<> inequality
!== non-identity
*/

// 8. Bitwise Operators

/* compares the bits in two operands
54 = 110110, 
40 = 101000,
so,
54 & 40 = 100000 (32)

54 | 45 = 111110 (62)
*/

$a = 54; $b = 40;
echo ($a & $b), "<br>";
echo ($a | $b), "<br>";

// Operator precedence

echo 20/2*2, "<br>"; // 20 or 5
echo 125/5**2, "<br>"; // 625 or 5
echo 12*6%4, "<br>"; // 0 or 24
echo 12+6%4, "<br>"; // 0 or 14

// the precedence order is:  **, /, *, %, +, -;

