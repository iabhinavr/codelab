<?php
date_default_timezone_set('Asia/Kolkata');
date_default_timezone_set('Africa/Cairo');
date_default_timezone_set('Europe/Paris');

$time = time();
echo "The current time is: ", $time, "<br>";

$date = date('d M Y', $time);

echo "Today's date is: ", $date, "<br>";

// from string - procedural

$dateString = "2022-07-25"; // should be a valid string

$dateObject = date_create($dateString); // returns a DateTime object

echo "<pre>", print_r($dateObject, true), "</pre>";

echo date_format($dateObject, 'l, d M Y'), "<br>";

// using predefined date constants in PHP

echo date_format($dateObject, DATE_ATOM), "<br>";
echo date_format($dateObject, DATE_COOKIE), "<br>";

// object-oriented style using DateTime class

$dateString = "2021-06-18";

$dateObject = new DateTime($dateString);

echo $dateObject->format('l, d M y'), "<br>";

// helps parsing tricky date formats

$dateString2 = "10-11-12";

/*
possibilites:
Nov 10, 2012 or Oct 11, 2012, or even 12 Nov, 2010
*/

// suppose it was Nov 10, 2012
$dateObject2 = DateTime::createFromFormat('d-m-y', $dateString2);
echo $dateObject2->format('M d Y'), "<br>";

//suppose it was Oct 11, 2012

$dateObject2 = DateTime::createFromFormat('m-d-y', $dateString2);
echo $dateObject2->format('M d Y'), "<br>";

// suppose it was Nov 12, 2010

$dateObject2 = DateTime::createFromFormat('y-m-d', $dateString2);
echo $dateObject2->format('M d Y'), "<br>";
echo $dateObject2->format('D, d M y'), "<br>";