<?php

function getAllGrade()
{
    require('inc/db.php');
    $stmt = "SELECT grade FROM grade";
    $stmtPrepare = $db->prepare($stmt);
    $stmtPrepare->execute();
    return $stmtPrepare->fetchAll(PDO::FETCH_ASSOC);
}