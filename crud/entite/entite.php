<?php
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

function getAllEntites()
{
    global $db;
    //$sqlGetAllEntity = "SELECT id, nom, uper_id from Entite order by nom";
    $sqlGetAllEntity = "CALL recursive_entite()";
    $sqlGetAllEntityPrepare = $db->prepare($sqlGetAllEntity);
    $sqlGetAllEntityPrepare->execute();
    $sqlGetAllEntityResults = $sqlGetAllEntityPrepare->fetchAll(PDO::FETCH_ASSOC);
    return $sqlGetAllEntityResults;
}

function getEntityById($idEntity)
{
    global $db;
    $sqlGetAllEntity = "SELECT en.id, nom, uper_id, Niveau, acronyme,email, tel, adresse_geo, adresse_postale,
    site, logo, addrGeo.Rue as rue_geo, en.compl_geo as compl_geo, addrGeo.CP as cp_geo, addrGeo.Ville as ville_geo,
     addrGeo.Pays as pays_geo, addrGeo.cedex as cedex_geo, addrPos.Rue as rue_pos, en.compl_postale as compl_pos,
     addrPos.CP as cp_pos, addrPos.Ville as ville_pos, addrPos.Pays as pays_pos, addrPos.cedex as cedex_pos
                        from Entite as en
                        left join address as addrGeo on addrGeo.id = en.adresse_geo
                        left join address as addrPos on addrPos.id = en.adresse_postale
                        where en.id = :id";
    $sqlGetAllEntityPrepare = $db->prepare($sqlGetAllEntity);
    $sqlGetAllEntityPrepare->execute(array(':id' => $idEntity));
    $sqlGetAllEntityResults = $sqlGetAllEntityPrepare->fetch(PDO::FETCH_ASSOC);
    return $sqlGetAllEntityResults;
}

function setEntity($nom, $Uper_id, $acronyme, $email, $tel, $adresse_geo, $adresse_pos, $site, $logo, $compl_geo, $compl_pos)
{
    global $db;
    $sqlSetEntityPrepare = $db->prepare('INSERT INTO Entite (Nom, Uper_id, acronyme, tel, adresse_geo, adresse_postale, site, logo, compl_geo, compl_postale, email) VALUES (:nom, :Uper_id, :acronyme, :tel, :adresse_geo, :adresse_postale, :site, :logo, :compl_geo, :compl_pos, :email)');
    $result = $sqlSetEntityPrepare->execute(array(':nom' => $nom, ':Uper_id' => $Uper_id, ':acronyme' => $acronyme, ':tel' => $tel, ':adresse_geo' => $adresse_geo, ':adresse_postale' => $adresse_pos, ':site' => $site, ':logo' => $logo, ':compl_geo' => $compl_geo, ':compl_pos' => $compl_pos, ':email' => $email));
    $sqlResultSetEntity = $db->lastInsertId();
    if (!$result) {
        print_r($db->errorInfo());
    }
    return $sqlResultSetEntity;
}

function deleteEntite($idEntity)
{
    global $db;
    $sqlDeleteEntite = "DELETE FROM Entite where id = :id";
    $queryDeleteEntite = $db->prepare($sqlDeleteEntite);
    $queryDeleteEntite->execute(array(':id' => $idEntity));
}

function updateEntite($idEntity, $nom, $uper_id, $acronyme, $email, $tel, $adresse_geo, $adresse_pos, $site, $logo, $compl_geo, $compl_pos)
{
    global $db;
    $sqlUpdateEntite = "UPDATE Entite SET Nom=:nom, Uper_id=:uper_id, acronyme=:acronyme, tel=:telephone, site=:site, logo=:logo, adresse_geo=:adresse_geo, adresse_postale=:adresse_postale, compl_geo=:compl_geo, compl_postale=:compl_pos, email=:email  where id=:id";
    $queryUpdateEntite = $db->prepare($sqlUpdateEntite);
    $result = $queryUpdateEntite->execute(array(':nom' => $nom, ':uper_id' => $uper_id, ':id' => $idEntity, ':acronyme' => $acronyme, ':telephone' => $tel, ':site' => $site, ':logo' => $logo, ':adresse_geo' => $adresse_geo, ':adresse_postale' => $adresse_pos, ':compl_geo' => $compl_geo, ':compl_pos' => $compl_pos, ':email' => $email));
    if (!$result) {
        print_r($db->errorInfo());
    }
    return $result;
}
