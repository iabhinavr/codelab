<?php

$url = "https://www.coralnodes.com/feed/";

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

$res = curl_exec($handle);

curl_close($handle);

$feed = new SimpleXMLElement($res);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML Parsing</title>
</head>
<body>
    <?php foreach($feed->channel->item as $item) : ?>
        <article>
            <h2><?= $item->title ?></h2>
            <p><?= $item->description ?></p>
        </article> 
    <?php endforeach; ?>
</body>
</html>
