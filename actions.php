<?php
include_once "inc/db.php";

switch ($_GET['type']) {
    case 'get':
        require "actions/entite/get_entite.php";
        break;
    case 'create':
        require "actions/entite/save_entite.php";
        break;
    case "delete":
        require "actions/entite/delete_entite.php";
        break;
    case 'update':
        require "actions/entite/update_entite.php";
        break;

    default:
        echo "error";
}