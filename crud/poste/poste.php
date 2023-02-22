<?php

require_once __DIR__ . "/../../config.php";
require_once SITE_ROOT . "/inc/helpers/debug.php";
require_once SITE_ROOT . "/inc/db.php";

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

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
    // $sqlRecupPosteContact = "SELECT Poste.id, Poste.Nom, ent0.Nom as 'entiteParent0',  ent1.Nom as 'entiteParent1'
    // from Poste join Entite as ent0 on (Poste.Entite = ent0.id) left join Entite as ent1 on (ent0.Uper_id=ent1.id)";
    $sqlRecupPosteContact = "CALL recursive_poste()";
    $queryRecupPosteContact = $db->prepare($sqlRecupPosteContact);
    $queryRecupPosteContact->execute();
    $resultRecupPosteContact = $queryRecupPosteContact->fetchAll(PDO::FETCH_ASSOC);
    return $resultRecupPosteContact;
}

function getEntiteDetailsOfPoste($id)
{
    global $db;
    $sqlgetEntiteDetailsOfPoste = "CALL recursive_poste_with_id(:id)";
    $querygetEntiteDetailsOfPoste = $db->prepare($sqlgetEntiteDetailsOfPoste);
    $querygetEntiteDetailsOfPoste->execute(array(':id' => $id));
    $resultgetEntiteDetailsOfPoste = $querygetEntiteDetailsOfPoste->fetchAll(PDO::FETCH_ASSOC);
    return $resultgetEntiteDetailsOfPoste;
}

function getPosteById($id)
{
    global $db;
    $sqlRecupPoste = "SELECT Poste.id, Poste.Nom, Poste.Entite ,  Poste.acronyme,
     Poste.adresse, Poste.email_secretariat, Poste.tel_secretariat, Poste.tel,
     Poste.Email_fonctionnel, addr.Rue, Poste.Compl, addr.CP, addr.Ville, addr.Pays
    from Poste
		left join `address` as addr on (Poste.adresse = addr.id)
	WHERE Poste.id = :id";
    $queryRecupPoste = $db->prepare($sqlRecupPoste);
    $queryRecupPoste->execute(array(':id' => $id));
    $resultRecupPoste = $queryRecupPoste->fetch(PDO::FETCH_ASSOC);
    return $resultRecupPoste;
}

function updatePoste($id, $nom, $email_fonc, $entite, $acronyme, $adresse, $email_secretariat, $tel_secretariat, $tel, $compl)
{
    global $db;
    $sqlUpdatePoste = "UPDATE Poste SET
        Nom=:nom, Email_fonctionnel=:email_fonc, Entite=:entite, acronyme=:acronyme, adresse=:adresse, email_secretariat=:email_secretariat, tel_secretariat=:tel_secretariat, tel=:tel, compl=:compl
	WHERE id=:id
";
    $queryUpdatePoste = $db->prepare($sqlUpdatePoste);
    $queryUpdatePoste->execute(array(':id' => $id, ':nom' => $nom, ':email_fonc' => $email_fonc, ':entite' => $entite, ':acronyme' => $acronyme, ':adresse' => $adresse, ':email_secretariat' => $email_secretariat, ':tel_secretariat' => $tel_secretariat, ':tel' => $tel, ':compl' => $compl));
    $resultUpdatePoste = $queryUpdatePoste->fetchAll(PDO::FETCH_ASSOC);
    if (!$resultUpdatePoste) {
        print_r($db->errorInfo());
    }
    return $resultUpdatePoste;
}

function setPoste($nom, $email_fonc, $entite, $acronyme, $email_secretariat, $tel_secretariat, $tel)
{

    global $db;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlSetPoste = "INSERT INTO Poste (Nom, Email_fonctionnel,
     Entite, acronyme, email_secretariat, tel_secretariat, tel)
	    VALUES (:nom, :email_fonc, :entite, :acronyme, :email_secretariat,
         :tel_secretariat, :tel)
";
    try {
        $querySetPoste = $db->prepare($sqlSetPoste);
        $querySetPoste->execute(array(
            ':nom' => $nom, ':email_fonc' => $email_fonc,
            ':entite' => $entite, ':acronyme' => $acronyme,
            ':email_secretariat' => $email_secretariat,
            ':tel_secretariat' => $tel_secretariat,
            ':tel' => $tel
        ));
        $resultSetPoste = $db->lastInsertId();
        return $resultSetPoste;
    } catch (Exception $e) {
        echo 'Exception -> ';
        var_dump($e->getMessage());
    }
}
function deletePoste($idPoste)
{
    global $db;
    $sqlDeletePoste = "DELETE FROM Poste where id = :id";
    $queryDeletePoste = $db->prepare($sqlDeletePoste);
    $queryDeletePoste->execute(array(':id' => $idPoste));
}
