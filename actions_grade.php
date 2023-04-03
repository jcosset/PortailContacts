<?php
include_once "inc/db.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

switch ($_GET['type']) {
    case 'get':
        require "actions/grade/get_grade.php";
        break;
    default:
        echo "error";
}