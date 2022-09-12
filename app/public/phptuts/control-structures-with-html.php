<?php

/*
if - elseif - else - endif
foreach - endforeach
while - endwhile
switch - endswitch
*/

$courses = [
    "PHP for Beginners",
    "Javascript - Beginner to Advanced",
    "MySQL Mastery",
    "Learn HTML and CSS"
];

//first start with true of false, then
// opened, closed, upcoming

$courseStatus = 'open';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Let's Learn Coding</h1>
    <?php if($courseStatus === 'open') : ?>
        <h2>List of courses available</h2>
        <ul>
        <?php foreach($courses as $c) : ?>
            <li><?php echo $c; ?></li>
        <?php endforeach; ?>
        </ul>
        
    <?php elseif($courseStatus === 'upcoming') : ?>
        <p>Will be available soon, check back later</p>
    <?php else : ?>
        <p>Sorry, no courses available currently</p>
    <?php endif; ?>
</body>
</html>