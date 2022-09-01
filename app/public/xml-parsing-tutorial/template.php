<!DOCTYPE html>
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