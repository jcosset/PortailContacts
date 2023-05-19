<?php
require_once __DIR__ . "/../../config.php";

if (isset($_REQUEST['all'])) {

    $sqlFetch = $db->prepare("SELECT id, grade from grade");

    if ($result = $sqlFetch->execute()) {
        $rows = $sqlFetch->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } else {
        echo json_encode("erreur");
    }
}