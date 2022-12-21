<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
function getListe()
{
    global $db;
    $sqlRecupListes = "SELECT * FROM Liste ORDER BY Nom";
    $queryRecupListes = $db->prepare($sqlRecupListes);
    $queryRecupListes->execute();
    $resultRecupListes = $queryRecupListes->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupListes;
}

function getContactsFromListe($idliste)
{
    global $db;
    $sqlRecupContacts = "SELECT * FROM Contacts_liste WHERE id_liste = $idliste";
    $queryRecupContacts = $db->prepare($sqlRecupContacts);
    $queryRecupContacts->execute();
    $resultRecupContacts = $queryRecupContacts->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupContacts;
}