<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once SITE_ROOT . "/inc/db.php";
function getContactFromPoste($id)
{
    global $db;
    $sqlRecupPosteContact = "SELECT Poste.Nom as poste , Entite.Nom as entite FROM Poste LEFT JOIN Entite ON Poste.Entite = Entite.id  WHERE Poste.id = '$id'";
    $queryRecupPosteContact = $db->prepare($sqlRecupPosteContact);
    $queryRecupPosteContact->execute();
    $resultRecupPosteContact = $queryRecupPosteContact->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupPosteContact;
}

function getAllPostes()
{
    global $db;
    $sqlRecupPosteContact = "SELECT Poste.id, Poste.Nom, ent0.Nom as 'entiteParent0',  ent1.Nom as 'entiteParent1'
    from Poste join Entite as ent0 on (Poste.Entite = ent0.id) left join Entite as ent1 on (ent0.Uper_id=ent1.id)";
    $queryRecupPosteContact = $db->prepare($sqlRecupPosteContact);
    $queryRecupPosteContact->execute();
    $resultRecupPosteContact = $queryRecupPosteContact->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupPosteContact;
}

function getEntiteDetailsOfPoste($id)
{
    global $db;
    $sqlgetEntiteDetailsOfPoste = "SELECT Poste.Nom as poste , Entite.Nom as entite FROM Poste LEFT JOIN Entite ON Poste.Entite = Entite.id  WHERE Poste.id = '$id'";
    $querygetEntiteDetailsOfPoste = $db->prepare($sqlgetEntiteDetailsOfPoste);
    $querygetEntiteDetailsOfPoste->execute();
    $resultgetEntiteDetailsOfPoste = $querygetEntiteDetailsOfPoste->fetchAll(PDO::FETCH_ASSOC);
    return $resultgetEntiteDetailsOfPoste;
}