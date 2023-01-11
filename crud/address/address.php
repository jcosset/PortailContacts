<?php
require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

function getAllAddresses()
{
    global $db;
    $sqlRecupAddresses = "SELECT * FROM address";
    $queryRecupAddresses = $db->prepare($sqlRecupAddresses);
    $queryRecupAddresses->execute();
    $resultRecupAddresses = $queryRecupAddresses->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupAddresses;
}

function getAddressById($idAddress)
{
    global $db;
    $queryRecupAddress = $db->prepare("SELECT * FROM address WHERE id = :idAddress");
    $queryRecupAddress->execute(array(':idAddress' => $idAddress));
    $resultRecupAddress = $queryRecupAddress->fetch(PDO::FETCH_ASSOC);
    return $resultRecupAddress;
}

function getIdAddress($address, $CP, $ville, $pays)
{
    global $db;
    $queryRecupIdAddress = $db->prepare('SELECT id from address where Rue=:adresse and CP=:CP and Ville=:ville and Pays=:pays;');
    $queryRecupIdAddress->execute(array(':adresse' => $address, ':CP' => $CP, ':ville' => $ville, ':pays' => $pays));
    $resultRecupIdAddress = $queryRecupIdAddress->fetch(PDO::FETCH_ASSOC);
    return $resultRecupIdAddress;
}

function setAddress($address, $complement, $CP, $ville, $pays, $cedex)
{
    global $db;
    if (!$complement) {
        $complement = "";
    }
    if (!$cedex) {
        $cedex = "";
    }
    $queryInsertAdress = $db->prepare('INSERT INTO address (Rue, Compl, CP, Ville, Pays, cedex)
        VALUES (:adresse, :complement, :CP, :ville, :pays, :cedex)');
    $queryInsertAdress->execute(array(':adresse' => $address, ':complement' => $complement, ':CP' => $CP, ':ville' => $ville, ':pays' => $pays, ':cedex' => $cedex));
    $addressID = $db->lastInsertId();
    return $addressID;
}

function deleteOrphanAddress()
{
    global $db;
    $queryRecupIdAddresses = $db->prepare('DELETE FROM address 
                                            WHERE id IN
                                                (SELECT * FROM (SELECT addr.id FROM address as addr 
                                                left join Contact as con on addr.id = con.addressId 
                                                left join Entite as en1 on addr.id = en1.adresse_geo 
                                                left join Entite as en2 on addr.id = en2.adresse_postale 
                                                left join Poste as pos on addr.id = pos.adresse 
                                                where con.addressId is null and en1.adresse_geo is null and en2.adresse_postale is null and pos.adresse is null)tblTMP)');
    $queryRecupIdAddresses->execute();
}