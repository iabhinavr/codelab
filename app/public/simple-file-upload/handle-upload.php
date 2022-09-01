<?php

if(isset($_FILES['myfiles'])) {

    $file_count = count($_FILES['myfiles']['name']);
    $ordered_array = [];

    for ($i = 0; $i < $file_count; $i++) {
        foreach($_FILES['myfiles'] as $key => $value) {
            $ordered_array[$i][$key] = $value[$i];
        }
    }

    foreach ($ordered_array as $file) {

        $upload_dir = './files-2/';
        $file_name = basename($file['name']);
        $path = $upload_dir . $file_name;

        if(move_uploaded_file($file['tmp_name'], $path)) {
            echo 'successfully uploaded ' . $file_name . '<br>';
        }
        else {
            echo 'could not upload' . $file_name;
        }
    }
}