<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

error_reporting(E_ALL);

function uploadFile($file, $name)
{
	$target_dir = "/../../images/upload/";
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
	$target_file = $target_dir . basename($name) . $imageFileType;

// Check if image file is a actual image or fake image
	$check = getimagesize($file["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}

// Check file size
	if ($file["size"] > 1000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}

// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		$uploadOk = 0;
	}

// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
// if everything is ok, try to upload file
		return "";
	} else {
		removeFile($name);
		if (move_uploaded_file($file["tmp_name"], $target_file)) {
			return $name . $imageFileType;
		} else {
			return "";
		}
	}
}

function removeFile($name){
	$path = "/../../images/upload/";
	array_map('unlink', glob($path.$name.".*"));
}

