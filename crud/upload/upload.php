<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

error_reporting(E_ALL);

function uploadFile($file)
{

	$imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	$check = getimagesize($file["tmp_name"]);
	if($check == false) {
		return false;
	}

// Check file size
	if ($file["size"] > 1000000) {
		return false;
	}

// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		return false;
	}

	return true;
}

function removeFile($name){
	array_map('unlink', glob($path.$name.".*"));
}