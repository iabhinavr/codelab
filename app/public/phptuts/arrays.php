<?php

// indexed array

$employees = array("Jane", "Joe", "Jacob");
$employees = ["Jane", "Joe", "Jacob"];

var_dump($employees);
var_dump($employees[1]);

// associative array

$employees = [
    "manager" => "Jane",
    "developer" => "Joe",
    "designer" => "Jacob"
];

var_dump($employees);
var_dump($employees['designer']);

// multidimensional array

$employees = [
    [
        "name" => "Jane", 
        "role" => "manager",
        "age" => 35
    ],
    [
        "name" => "Joe", 
        "role" => "developer",
        "age" => 30
    ],
    [
        "name" => "Jacob", 
        "role" => "designer",
        "age" => 25
    ]
];

// getting the length of array

$count = count($employees);

var_dump($count);

// iterating arrays - foreach

foreach($employees as $employee) {
    echo 'Name:' . $employee['name'];
    echo '<br>';
    echo 'Role:' . $employee['role'];
    echo '<br>';
    echo 'Age:' . $employee['age'];
    echo '<br>';
    echo '<br>';
}

