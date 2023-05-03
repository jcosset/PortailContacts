<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once SITE_ROOT . "/crud/upload/upload.php";


if (isset($_FILES)) {
    $photo = $_FILES['logo'];
    $destdir = 'upload/contact/photo/';

    $file = $_FILES['logo']['name'];
    $path = pathinfo($file);
	$filename = md5($path['filename'].rand(0, 150000)).".".$path['extension'];
	$temp_name = $_FILES['logo']['tmp_name'];
	$path_filename_ext = $destdir.$filename;

    if (uploadFile($photo)) {
        if (move_uploaded_file($temp_name, $path_filename_ext)) {
            echo json_encode(["path" => $filename]);
            return true;
        } else {
            echo "Error while uploading photo";
            return false;
        }
    } else {
        return false;
    }
    
}