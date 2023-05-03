<?php
require_once __DIR__ . "/../../config.php";
require_once __DIR__ . "/../../crud/address/address.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once SITE_ROOT . "/inc/db.php";
function getContact($idcontact)
{
    global $db;
    $sqlRecupContacts = "SELECT con.id,`Civilite`, `Nom`,`Prenom`,`Grade`,`Email`,`Statut`,`Photo`,`Poste_actuel`,`date_debut`,`Date_MAJ`,`TAG`,`Commentaire`,`telephone`,`email_pro`,`commentaire_niv_2`,`addressID`, `Rue`, `Compl`, `CP`, `Ville`, `Pays`, `cedex`
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
    $sqlRecupContacts = "SELECT id, Nom, Prenom, Grade, Email, Statut, Poste_actuel, date_debut, email_pro, telephone
     FROM Contact ORDER BY Nom";
    $queryRecupContacts = $db->prepare($sqlRecupContacts);
    $queryRecupContacts->execute();
    $resultRecupContacts = $queryRecupContacts->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupContacts;
}

function updateContact(
    $id,
    $nom,
    $prnom,
    $civil,
    $photo,
    $poste,
    $date_debut,
    $grade,
    $email,
    $tag,
    $comment,
    $emailPro,
    $telephone,
    $commentaireNiv2,
    $adresseId,
    $complement,
    $statut
) {
    global $db;
    $sqlUpdateContact = "UPDATE Contact SET Nom=:nom, Prenom=:prenom, Civilite=:civil,
    Photo=:photo, Poste_actuel=:poste, date_debut=:date_debut, Grade=:grade, Email=:email,
    TAG=:tag, Commentaire=:comment, email_pro=:emailPro, telephone=:telephone,
    commentaire_niv_2=:commentaireNiv2, addressID=:addressID, compl=:compl, Statut=:statut
    where id=:id";
    $queryUpdateContact = $db->prepare($sqlUpdateContact);
    return $queryUpdateContact->execute(array(
        ':nom' => $nom, ':prenom' => $prnom, ':civil' => $civil, ':photo' => $photo,
        ':poste' => $poste, ':date_debut' => date('Y-m-d', strtotime($date_debut)),
        ':grade' => $grade, ':email' => $email, ':tag' => $tag,
        ':comment' => $comment, ':emailPro' => $emailPro, ':telephone' => $telephone,
        ':commentaireNiv2' => $commentaireNiv2, ':id' => $id, ':addressID' => $adresseId,
        ':compl' => $complement, ':statut' => $statut
    ));
}

function deleteContact($idContact)
{
    global $db;
    $sqlDeleteContact = "DELETE FROM Contact where id = :id";
    $queryDeleteContact = $db->prepare($sqlDeleteContact);
    $queryDeleteContact->execute(array(':id' => $idContact));
}