<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";


if (isset($_FILES)) {
    $logo = $_FILES['logo'];
    $destdir = 'upload/gestion/logo/';

    $file = $_FILES['logo']['name'];
    $path = pathinfo($file);
	$filename = md5($path['filename'].rand(0, 15000)).".".$path['extension'];
	$temp_name = $_FILES['logo']['tmp_name'];
	$path_filename_ext = $destdir.$filename;

    if (move_uploaded_file($temp_name, $path_filename_ext)) {
        echo json_encode(["path" => $filename]);
    } else {
        echo "error while uploading logo";
    }
}