<?php 
include_once "inc/db.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

switch($_GET['type'])
{
case 'get': require "actions/poste/get_poste.php"; break;
case 'create': require "actions/poste/save_poste.php"; break;
case "delete": require "actions/poste/delete_poste.php"; break;
case 'update': require "actions/poste/update_poste.php"; break;

default: echo "error";
}
