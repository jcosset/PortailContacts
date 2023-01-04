<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once SITE_ROOT . "/inc/db.php";
function getContact($idcontact)
{
    global $db;
    $sqlRecupContacts = "SELECT con.id,`Civilite`, `Nom`,`Prenom`,`Grade`,`Email`,`Statut`,`Photo`,`Poste_actuel`,`Date_MAJ`,`TAG`,`Commentaire`,`telephone`,`email_pro`,`commentaire_niv_2`,`addressID`, `Rue`, `Compl`, `CP`, `Ville`, `Pays`, `cedex` 
                            FROM `Contact` as con 
                            left Join `address` as addr on addr.id = con.addressID 
                            WHERE id = $idcontact";
    $queryRecupContacts = $db->prepare($sqlRecupContacts);
    $queryRecupContacts->execute();
    $resultRecupContacts = $queryRecupContacts->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupContacts;
}

function getAllContacts()
{
    global $db;
    $sqlRecupContacts = "SELECT id, Nom, Prenom, Grade, Email, Statut, Poste_actuel, email_pro, telephone
     FROM Contact ORDER BY Nom";
    $queryRecupContacts = $db->prepare($sqlRecupContacts);
    $queryRecupContacts->execute();
    $resultRecupContacts = $queryRecupContacts->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupContacts;
}