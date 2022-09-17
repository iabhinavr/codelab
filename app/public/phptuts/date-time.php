<?php

date_default_timezone_set('Asia/Kolkata');
// date_default_timezone_set('Africa/Cairo');
// date_default_timezone_set('Europe/Paris');

$time = time();
echo "The current time is: ", $time, "<br>";

$date = date('d M Y', $time);
echo "Today's date is: ", $date, "<br>";

// eg; Sep 18, 2022 12:30 AM Asia/Kolkata

$date = date('M d, Y g:i a e');
echo "The current date and time is: ", $date, "<br>";

// from string - procedural

$dateString = "2022-07-25"; // should be a valid string

$dateObject = date_create($dateString); // returns a DateTime object

echo "<pre>", print_r($dateObject, true), "</pre>";

echo date_format($dateObject, 'D, d M Y'), "<br>";
echo date_format($dateObject, 'l, jS F Y'), "<br>";

// using predefined date constants in PHP

echo date_format($dateObject, DATE_ATOM), "<br>";
echo date_format($dateObject, DATE_COOKIE), "<br>";

// object-oriented style using DateTime class

$dateString = "2021-06-18";
$dateObject = new DateTime($dateString);

echo $dateObject->format('l, d M y'), "<br>";

// helps parsing tricky date formats

$dateString = "10/11/12";

/*
possibilites:
Nov 10, 2012 or Oct 11, 2012, or even 12 Nov, 2010
*/

$dateObject1 = new DateTime($dateString);
echo $dateObject1->format('M d Y'), "<br>";

// suppose it was Nov 10, 2012
$dateObject2 = DateTime::createFromFormat('d/m/y', $dateString);
echo $dateObject2->format('M d Y'), "<br>";

// suppose it was Nov 12, 2010

$dateObject2 = DateTime::createFromFormat('y/m/d', $dateString);
echo $dateObject2->format('M d Y'), "<br>";
echo $dateObject2->format('D, d F Y'), "<br>";

// difference between two dates in no. of days

$dateString1 = "15-08-2014"; // Aug 15, 2014
$dateString2 = "05/09/21"; //  Sep 5, 2021

$dateObject1 = DateTime::createFromFormat('d-m-Y', $dateString1);
$dateObject2 = DateTime::createFromFormat('d/m/y', $dateString2);

$dateInterval = $dateObject2->diff($dateObject1);
echo $dateInterval->format("%a days");