<?php

function check_extensions() {
    $gd = false;
    $gd_jpeg = false;
    $gd_png = false;
    $imagick = false;

    if(extension_loaded('gd')) {
        $gd = true;
    
        if(function_exists('imagecreatefromjpeg')) {
            $gd_jpeg = true;
        }
        if(function_exists('imagecreatefrompng')) {
            $gd_png = true;
        }
    }
    
    if(extension_loaded('imagick')) {
        $imagick = true;
    }

    return [
        'gd' => $gd,
        'gd_jpeg' => $gd_jpeg,
        'gd_png' => $gd_png,
        'imagick' => $imagick
    ];
}

function resize_jpeg_gd($src_file, $dest_width, $dest_file, $quality = 80) {
    $src = imagecreatefromjpeg($src_file);

    if($src) {
        $src_width = imagesx($src);
        $src_height = imagesy($src);

        $dest_height = floor(($src_height / $src_width) * $dest_width);

        $dest = imagecreatetruecolor($dest_width, $dest_height);

        imagecopyresampled($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
        if (imagejpeg($dest, $dest_file, $quality)) {
            return ["status" => true, "result" => "JPEG image successfully resized using GD", "image" => $dest_file];
        }

    }
    return ["status" => false, "result" => "GD Error resizing JPEG image"];
}

function resize_png_gd($src_file, $dest_width, $dest_file, $quality = null) {

    $src = imagecreatefrompng($src_file);

    if($src) {
        $src_width = imagesx($src);
        $src_height = imagesy($src);

        $dest_height = floor(($src_height / $src_width) * $dest_width);

        $dest = imagecreatetruecolor($dest_width, $dest_height);

        imagecopyresampled($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
        if(imagepng($dest, $dest_file, 9)) {
            return ["status" => true, "result" => "PNG image successfully resized using GD",  "image" => $dest_file];
        }

    }

    return ["status" => false, "result" => "GD Error resizing PNG image"];
}

function resize_image_imagick($src_file, $dest_width, $dest_file, $quality = 80) {
    $image = new Imagick();
    $image->readImage($src_file);

    if($image) {
        $src_width = $image->getImageWidth();
        $src_height = $image->getImageHeight();

        $image->resizeImage($dest_width, 0, Imagick::FILTER_LANCZOS, 1);

        $image->setImageCompressionQuality($quality);

        if ($image->writeImage($dest_file)) {
            return ["status" => true, "result" => "Image successfully resized using Imagick", "image" => $dest_file];
        }
    }
    return ["status" => false, "result" => "Imagick could not resize the image"];  
}

$extensions = check_extensions();

if(!empty($_FILES['imagefile'])) {

    $dest_width = (int)$_POST['width'];
    $quality = (int)$_POST['quality'];
    
    $image_type = $_FILES['imagefile']['type'];
    $image_name = $_FILES['imagefile']['name'];
    $image_tmp_name = $_FILES['imagefile']['tmp_name'];


    // just cleaning up the filename

    $image_name = str_replace(" ", "-", $image_name);

    $gd_func = false;
    $valid_mime = true;

    if($image_type === 'image/jpeg') {
        $gd_func = ($extensions['gd'] && $extensions['gd_jpeg']) ? 
        'resize_jpeg_gd' : false;
    }
    else if($image_type === 'image/png') {

        $gd_func = ($extensions['gd'] && $extensions['gd_png']) ? 
        'resize_png_gd' : false;
    }
    else {
        $valid_mime = false;
    }

    if($gd_func) {
        $resize = call_user_func($gd_func, $image_tmp_name, $dest_width, "images/" . $image_name, $quality);
    }
    else if($extensions['imagick'] && $valid_mime) {
        $resize = call_user_func('resize_image_imagick', $image_tmp_name, $dest_width, "images/" . $image_name, $quality);
    }
    else {
        $resize = ["status" => false, "result" => "Unable to resize!"];
    }

}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resize Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="my-3">
            <h2 class="my-3 fs-4">Extension Info:</h2>
            <div class="alert alert-info">
                <p>
                    <?php echo $extensions['gd'] ?
                    'GD is enabled' : 'GD is not enabled' ?>
                </p>
                <p>
                    <?php echo $extensions['gd_jpeg'] ?
                    'GD can edit jpeg' : 'GD cannot edit jpeg' ?>
                </p>
                
                <p>
                    <?php echo $extensions['gd_png'] ?
                    'GD can edit png' : 'GD cannot edit png'; ?>
                </p>
                <p>
                    <?php echo $extensions['imagick'] ?
                    'Imagick is enabled <br>' : 'Imagick is not enabled'; ?>
                </p>
            </div>
        </div>
        <h2 class="my-3 fs-4">Resize Image</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="width" class="form-label">Enter the width:</label>
                <input type="number" name="width" id="width" value="600" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="file" name="imagefile" id="imagefile" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="quality" class="form-label">Quality (for JPEG):</label>
                <input type="range" name="quality" id="quality" min="1" max="100" value="80" class="form-range" oninput="this.nextElementSibling.value=this.value">
                <output></output>
            </div>
            <button type="submit" name="resize" id="resize" class="btn btn-primary">Submit</button>
        </form>

        <?php if(!empty($resize) && ($resize['status'] === true)) : ?>
            <div class="alert alert-success mt-3"><?= $resize['result'] ?></div>
            <h3 class="fs-4">Resized Image:</h3>
            <img src="<?= $resize['image'] ?>" alt="">
        <?php elseif(!empty($resize) && ($resize['status'] === false)) : ?>
            <div class="alert alert-danger"><?= $resize['result'] ?></div>
        <?php endif; ?>
    
    </div>
</body>
</html>

