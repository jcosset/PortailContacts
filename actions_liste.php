<?php
include_once "inc/db.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

switch ($_GET['type']) {
        //case 'create': require "actions/poste/save_poste.php"; break;
    case "get":
        require "actions/liste/get_liste.php";
        break;
    case "create":
        require "actions/liste/save_liste.php";
        break;
    case "delete":
        require "actions/contact/delete_contact.php";
        break;
    case "update":
        require "actions/contact/update_contact.php";
        break;

    case "addPoste":
        require "actions/liste/poste/save_poste.php";
        break;

    default:
        echo "error";
}