<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

function getAllEntites()
{
    global $db;
    $sqlGetAllEntity = "SELECT id, nom, uper_id from Entite order by nom";
    $sqlGetAllEntityPrepare = $db->prepare($sqlGetAllEntity);
    $sqlGetAllEntityPrepare->execute();
    $sqlGetAllEntityResults = $sqlGetAllEntityPrepare->fetchAll(PDO::FETCH_ASSOC);
    return $sqlGetAllEntityResults;
}