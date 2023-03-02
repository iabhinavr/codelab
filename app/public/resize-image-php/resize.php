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

function resize_imagick($src_file, $dest_width, $dest_file) {
    $image = new Imagick();
    $image->readImage($src_file);

    if($image) {
        $src_width = $image->getImageWidth();
        $src_height = $image->getImageHeight();

        $dest_height = floor(($src_height / $src_width) * $dest_width);

        $image->resizeImage($dest_width, 0, Imagick::FILTER_LANCZOS, 1);

        $image->setImageCompressionQuality(80);
        if ($image->writeImage($dest_file)) {
            return ["status" => true, "result" => "Image successfully resized using Imagick", "image" => $dest_file];
        }
    }

    
}

function resize_gd_jpeg($src_file, $dest_width, $dest_file) {
    $src = imagecreatefromjpeg($src_file);

    if($src) {
        $src_width = imagesx($src);
        $src_height = imagesy($src);

        $dest_height = floor(($src_height / $src_width) * $dest_width);

        $dest = imagecreatetruecolor($dest_width, $dest_height);

        imagecopyresampled($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
        if (imagejpeg($dest, $dest_file, 80)) {
            return ["status" => true, "result" => "JPEG image successfully resized using GD", "image" => $dest_file];
        }

    }
    return ["status" => false, "result" => "GD Error resizing JPEG image"];
}

function resize_gd_png($src_file, $dest_width, $dest_file) {

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

$extensions = check_extensions();

if(isset($_POST['resize'])) {

    $resize = false;
    $gd_func_available = false;

    $dest_width = (int)$_POST['width'];
    $image_type = $_POST['imagetype'];

    if($image_type === 'jpg') {
        $src_file = 'images/original/polynesia.jpg';
        $dest_file = 'images/resized/polynesia.jpg';
        $gd_func = 'resize_gd_jpeg';
        $gd_func_available = ($extensions['gd'] && $extensions['gd_jpeg']);
    }
    else if($image_type === 'png') {
        $src_file = 'images/original/forest.png';
        $dest_file = 'images/resized/forest.png';
        $gd_func = 'resize_gd_png';
        $gd_func_available = ($extensions['gd'] && $extensions['gd_png']);
    }

    if($gd_func_available) {
        $resize = call_user_func($gd_func, $src_file, $dest_width, $dest_file);
    }
    else if($extensions['imagick']) {
        $resize = call_user_func('resize_imagick', $src_file, $dest_width, $dest_file);
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
        <form action="" method="POST">
            <div class="mb-3">
                <label for="width" class="form-label">Enter the width:</label>
                <input type="number" name="width" id="width" value="600" class="form-control">
            </div>
            <div class="mb-3">
                <div class="d-flex">
                    <div class="me-3">
                        <img src="images/original/forest.png" alt="" width="150" height="100">
                        <br>
                        <input type="radio" name="imagetype" id="png" value="png">
                        <label for="png">Resize PNG</label>
                    </div>
                    <div class="me-3">
                        <img src="images/original/polynesia.jpg" alt="" width="150" height="100">
                        <br>
                        <input type="radio" name="imagetype" id="jpg" value="jpg">
                        <label for="jpg">Resize JPG</label>
                    </div>
                </div>
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

